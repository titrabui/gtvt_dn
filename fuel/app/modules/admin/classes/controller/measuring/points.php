<?php

namespace Admin;

class Controller_Measuring_Points extends Controller_Base {

	public function before()
	{
		parent::before();

	}

	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_view($id = null)
	{
/*		try
		{*/
			is_null($id) and \Response::redirect('admin/projects');

			if ( ! $project = \Model_Project::find($id))
			{
				\Session::set_flash('error', 'Không tồn tại dự án #'.$id);
				\Response::redirect('admin/error');
			}

			// pagination config
			$config = array(
				'name'           => 'bootstrap3',
				'pagination_url' => \Uri::create('admin/measuring_points/view/'.$id),
				'total_items'    => \Model_Measuring_Point::query()->count(),
				'num_link'       => '5',
				'per_page'       => '20',
				'uri_segment'    => 'page',
			);

			$pagination = \Pagination::forge('measuring_points_pagination', $config);

			$data['measuring_points'] = \Model_Measuring_Point::query()
				->where('project_id', $id)
				->rows_offset($pagination->offset)
				->rows_limit($pagination->per_page)
				->get();

			$data['pagination'] = $pagination;

			$this->template->content = \View::forge('measuring_points/view', $data);
/*		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}*/
	}

	/**
	 * The register action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_register()
	{
		try
		{
			// remove milestone session
			\Session::get('milestone') and \Session::delete('milestone');

			if (\Input::method() == 'POST' &&  ! \Input::post('back'))
			{
				$val = \Model_Milestone::validate('register');

				if ($val->run())
				{
					if ( ! $pagetitle = $this->get_page_title(\Input::post('url')))
					{
						\Session::set_flash('error','このURLが存在しない');
					}
					else
					{
						$milestone = \Model_Milestone::forge(array(
							'published'   => \Input::post('published'),
							'title'	      => \Input::post('title'),
							'description' => \Input::post('description'),
							'url'         => \Input::post('url'),
							'pagetitle'   => strpos($pagetitle, '\'') ? str_replace('\'', '', $pagetitle) : $pagetitle, // remove character ";" in pagetitle
						));

						\Session::set('milestone', $milestone);
						\Response::redirect('manager/milestones/confirm');
					}
				}
				else
				{
					\Session::set_flash('error', $val->error());
				}
			}

			$this->template->content = \View_Smarty::forge('milestones/register.tpl');
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The edit action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_edit($id = null)
	{
		try
		{
			// remove milestone session
			\Session::get('milestone') and \Session::delete('milestone');

			is_null($id) and \Response::redirect('manager/milestones');

			if ( ! $milestone = \Model_Milestone::find($id))
			{
				\Session::set_flash('error', 'マイルストーンが見つかりません #'.$id);
				\Response::redirect('manager/error');
			}

			if ( ! \Input::post('back'))
			{
				$val = \Model_Milestone::validate('edit');

				if ($val->run())
				{
					if ( ! $pagetitle = $this->get_page_title(\Input::post('url')))
					{
						\Session::set_flash('error','このURLが存在しません。');
					}
					else
					{
						$milestone->id          = $id;
						$milestone->published   = \Input::post('published');
						$milestone->title       = \Input::post('title');
						$milestone->description = \Input::post('description');
						$milestone->url         = \Input::post('url');
						$milestone->pagetitle   = strpos($pagetitle, '\'') ? str_replace('\'', '', $pagetitle) : $pagetitle;	// remove character ";" in pagetitle
					
						\Session::set('milestone', $milestone);
						\Response::redirect('manager/milestones/confirm/'.$id);
					}
				}
				else
				{
					if (\Input::method() == 'POST')
					{
						$milestone->title = $val->validated('title');
						$milestone->description = $val->validated('description');
						$milestone->url = $val->validated('url');

						\Session::set_flash('error', $val->error());
					}
				}
			}

			$this->template->content = \View_Smarty::forge('milestones/edit.tpl', array('milestone' => $milestone));
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The confirm action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_confirm($id = null)
	{
		try
		{
			if (\Input::method() != 'POST')
			{
//				echo 'bad route!!!';
				// prevent redirect without milestones data from edit or register
				(\Input::referrer() == '') and $this->redirect_to_error_page('正しいルートから来ていません。');
			}
			else
			{
				// remove milestone session
				\Session::delete('milestone');

				( ! is_null($id) && ! $milestone = \Model_Milestone::find($id)) and $this->redirect_to_error_page('マイルストーンが見つかりません。 #'.$id);

				// check token from confirm form
				\Security::check_token() or $this->redirect_to_error_page(\Constants::$error_message['expired_csrf_token']);

				$val = \Model_Milestone::validate('confirm');

				if ($val->run())
				{
					if (isset($milestone))
					{
						// save data to edit
						$milestone->id          = $id;
						$milestone->published   = \Input::post('published');
						$milestone->title       = \Input::post('title');
						$milestone->description = \Input::post('description');
						$milestone->url         = \Input::post('url');
						$milestone->pagetitle   = \Input::post('pagetitle');
					}
					else
					{
						// create new one and save data to register
						$milestone = \Model_Milestone::forge(array(
							'milestone'   => $this->get_milestone_character(),
							'published'   => \Input::post('published'),
							'title'		  => \Input::post('title'),
							'description' => \Input::post('description'),
							'pageid' 	  => '0',
							'url' 		  => \Input::post('url'),
							'pagetitle'	  => \Input::post('pagetitle'),
						));
					}

					// take screenshot thumbnail
					$this->take_screenshot_thumbnail(str_replace('%','',urlencode($milestone->milestone)), $milestone->url);

					// save milestone
					($milestone and $milestone->save()) or $this->redirect_to_error_page('マイルストーンを保存出来ませんでした。');
					\Session::set_flash('complete', 'complete');
					\Response::redirect('manager/milestones/complete');	
				}
				else
				{
					$this->redirect_to_error_page($val->error());
				}
			}
		
			$this->template->content = \View_Smarty::forge('milestones/confirm.tpl');
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The complete action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_complete()
	{
		\Session::get_flash('complete') or \Response::redirect('manager/milestones');
		$this->template->content = \View_Smarty::forge('milestones/complete.tpl');
	}

	/**
	 * The search API action, method GET.
	 *
	 * @access  public
	 * @return  milestones data json
	 */
	public function get_apisearch()
	{
		try
		{
			// utf-8 compatible parse_url() replacement
			$enc_url = preg_replace_callback(
				'%[^:/@?&=#]+%usD',
				function ($matches)
				{
					return urlencode($matches[0]);
				},
				\Uri::create('manager/milestones/search?title='.\Input::get('title').'&url='.\Input::get('url'))
			);

			// set pagination config
			$config = array(
				'name'           => 'bootstrap3',
				'pagination_url' => $enc_url,
				'total_items'    => \Model_Milestone::query()
										->where('title', 'LIKE', "%".\Input::get('title')."%")
										->and_where_open()
											->where('url', 'LIKE', "%".\Input::get('url')."%")
										->and_where_close()->count(),
				'num_link'       => '5',
				'per_page'       => '10',
				'uri_segment'    => 'page',
			);

			$pagination = \Pagination::forge('milestonespagination', $config);

			$milestones = \Model_Milestone::query()
				->where('title', 'LIKE', "%".\Input::get('title')."%")
					->and_where_open()
						->where('url', 'LIKE', "%".\Input::get('url')."%")
					->and_where_close()
				->rows_offset($pagination->offset)
				->rows_limit($pagination->per_page)
				->get();

			// convert pagination into html
			$data['pagination'] = html_entity_decode($pagination);

			// create index of milestone table
			$table_index = ((\Input::get('page') - 1) * $config['per_page']) + 1;

			// convert milestones array into json
			$data['milestones'] = array();
			foreach ($milestones as $item) {
				$data['milestones'][] = array(
					'tableid'   => $table_index++,
					'id'        => $item->id,
					'milestone' => $item->milestone,
					'title'     => $item->title,
					'url'       => $item->url,
					'pagetitle' => $item->pagetitle
				);
			}

			$this->response($data);
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The action for getting pagetitle from an existing url.
	 *
	 * @access  private
	 * @return  String: pagetitle
	 */
	private function get_page_title($url)
	{
		try
		{
			$doc = new \DOMDocument();
			libxml_use_internal_errors(true);
			@$doc->loadHTMLFile($url);

			// URL is not exist
			if ( ! $doc->textContent)
			{
				return '';
			}

			$xpath = new \DOMXPath($doc);

			// return page title
			return is_null($xpath->query('//title')->item(0)) ? 'ページタイトルはありません' : $xpath->query('//title')->item(0)->nodeValue;
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The action get milestone unique character of the last milestone
	 *
	 * @access  private
	 * @return  '０': last milestone is null
	 *          milestone unique character: last milestone is available
	 */
	private function get_milestone_character()
	{
		try
		{
			// get last milestone
			$last_milestone = \Model_Milestone::find('last');

			return is_null($last_milestone) ? '０' : Func::getNextMilestone($last_milestone->milestone);
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The function for redirecting to error page
	 *
	 * @access  private
	 * @return  none
	 */
	private function redirect_to_error_page($message = array())
	{
		// remove milestone session
		\Session::get('milestone') and \Session::delete('milestone');

		// redirect to error page
		\Session::set_flash('error', $message);
		\Response::redirect('manager/error');
	}

	/**
	 * The function for taking screenshot thumbnail
	 *
	 * @access  private
	 * @return  none
	 */
	private function take_screenshot_thumbnail($milestone, $url)
	{
		try
		{
			// create terminal command
			$command = sprintf(
				'sudo -i sh %s %s %s %d %d %s',
				APPPATH.'vendor/nodejs/shot-tool.sh',	// path of main js file
				$milestone,								// screenshot file name
				$url,									// url to get screenshot
				600,									// screenshot width
				800,									// screenshot height
				DOCROOT.'assets/img/milestones/'		// directory to save screenshot
			);
//			\Log::info($command);
			// execute command
			exec($command, $output_message);
			$output_message and $this->redirect_to_error_page('サムネイルの画像の取得に失敗しました。');
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

}

/* End of file projects.php */