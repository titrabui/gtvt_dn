<?php

namespace Admin;
require_once (APPPATH.'vendor'.DS.'excel'.DS.'export.php');

class Controller_Measuring_Values extends Controller_Base {

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
		try
		{
			is_null($id) and \Response::redirect('admin/projects');

			if ( ! $measuring_points = \Model_Measuring_Point::find($id))
			{
				\Session::set_flash('error', 'Không tồn tại điểm đo #'.$id);
				\Response::redirect('admin/error');
			}

			$data['measuring_points'] = $measuring_points;

			// Get all measuring month
			$measuring_created = \Model_Measuring_Value::query()
				->select(array('created_at'))
				->where('measuring_point_id', $id)
				->order_by('created_at', 'desc')
				->from_cache(false)
				->get();

			$measuring_months = array();
			foreach ($measuring_created as $item)
			{
				$measuring_months[\Date::forge($item['created_at'])->format("%m/%Y")]
					= \Date::forge($item['created_at'])->format("%m/%Y");
			}

			$data['measuring_months'] = $measuring_months;

			// if month is null then get month selected is current month
			$month_selected = \Input::get('month_selected');
			if (is_null($month_selected))
			{
				if (count($measuring_months))
				{
					reset($measuring_months);
					$month_selected = key($measuring_months);
				}
				else
				{
					$month_selected = \Date::forge(time())->format("%m/%Y");
				}
			}

			$data['month_selected'] = $month_selected;
			$array_temp = explode('/', $month_selected);

			// pagination config
			$config = array(
				'name'           => 'bootstrap3',
				'pagination_url' => \Uri::create('admin/measuring_values/view/'.$id.'?month_selected='.$month_selected),
				'total_items'    => \Model_Measuring_Value::query()
					->where('measuring_point_id', $id)
					->and_where_open()
						->where(\DB::expr('MONTH(FROM_UNIXTIME(created_at))'), $array_temp[0])
					->and_where_close()
					->and_where_open()
						->where(\DB::expr('YEAR(FROM_UNIXTIME(created_at))'), $array_temp[1])
					->and_where_close()
					->order_by('created_at', 'desc')
					->from_cache(false)->count(),
				'num_link'       => '5',
				'per_page'       => '20',
				'uri_segment'    => 'page',
			);

			$pagination = \Pagination::forge('measuring_values_pagination', $config);

			// Get measuring data
			$data['measuring_values'] = \Model_Measuring_Value::query()
				->where('measuring_point_id', $id)
				->and_where_open()
					->where(\DB::expr('MONTH(FROM_UNIXTIME(created_at))'), $array_temp[0])
				->and_where_close()
				->and_where_open()
					->where(\DB::expr('YEAR(FROM_UNIXTIME(created_at))'), $array_temp[1])
				->and_where_close()
				->rows_offset($pagination->offset)
				->rows_limit($pagination->per_page)
				->order_by('created_at', 'desc')
				->from_cache(false)
				->get();

			$data['pagination'] = $pagination;

			$this->template->content = \View::forge('measuring_values/view', $data);
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The delete action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_delete($id = null)
	{
		( ! \Input::get('measuring_point')) and \Response::redirect('admin/projects');

		if ( ! is_null($id) && ! $measuring_value = \Model_Measuring_Value::find($id))
		{
			$this->redirect_to_error_page(array('message' => 'Không tồn tại giá trị đo #'.$id));
		}

		$measuring_point_id = \Input::get('measuring_point');
		if ( ! $measuring_point = \Model_Measuring_Point::find($measuring_point_id))
		{
			$this->redirect_to_error_page(array('message' => 'Không tồn tại điểm đo #'.$measuring_point_id));
		}

		$measuring_value->delete() or $this->redirect_to_error_page(array('message' => 'Không thể xóa giá trị đo này'));
		\Response::redirect('admin/measuring_values/view/'.$measuring_point_id);
	}

	/**
	 * The excel report export action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_report($id = null)
	{
/*		try
		{*/
			is_null($id) and \Response::redirect('admin/projects');

			if ( ! $measuring_points = \Model_Measuring_Point::find($id))
			{
				\Session::set_flash('error', 'Không tồn tại điểm đo #'.$id);
				\Response::redirect('admin/error');
			}

			$data['measuring_points'] = $measuring_points;

			// Get all measuring month
			$measuring_created = \Model_Measuring_Value::query()
				->select(array('created_at'))
				->where('measuring_point_id', $id)
				->order_by('created_at', 'desc')
				->from_cache(false)
				->get();

			$measuring_months = array();
			foreach ($measuring_created as $item)
			{
				$measuring_months[\Date::forge($item['created_at'])->format("%m/%Y")]
					= 'Tháng '.\Date::forge($item['created_at'])->format("%m/%Y");
			}

			$data['measuring_months'] = $measuring_months;

			// if month is null then get month selected is current month
			$month_selected = \Input::get('month_selected');
			if (is_null($month_selected))
			{
				if (count($measuring_months))
				{
					reset($measuring_months);
					$month_selected = key($measuring_months);
				}
				else
				{
					$month_selected = \Date::forge(time())->format("%m/%Y");
				}
			}

			$array_temp = explode('/', $month_selected);

			// Get measuring data
			$measuring_values = \Model_Measuring_Value::query()
				->where('measuring_point_id', $id)
				->and_where_open()
					->where(\DB::expr('MONTH(FROM_UNIXTIME(created_at))'), $array_temp[0])
				->and_where_close()
				->and_where_open()
					->where(\DB::expr('YEAR(FROM_UNIXTIME(created_at))'), $array_temp[1])
				->and_where_close()
				->order_by('created_at', 'desc')
				->from_cache(false)
				->get();

			\Excel::export($measuring_values, str_replace('/', '-', $month_selected));
			
			exit();
/*		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}*/
	}

	/**
	 * The function for redirecting to error page
	 *
	 * @access  private
	 * @return  none
	 */
	private function redirect_to_error_page($message = array())
	{
		// redirect to error page
		\Session::set_flash('error', $message);
		\Response::redirect('admin/error');
	}
}

/* End of file measuring_values.php */