<?php

namespace Admin;

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
		// remove milestone session
		\Session::get('milestone') and \Session::delete('milestone');

		// redirect to error page
		\Session::set_flash('error', $message);
		\Response::redirect('manager/error');
	}
}

/* End of file measuring_values.php */