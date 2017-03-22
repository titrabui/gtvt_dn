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
	public function action_view($id = null, $month_selected = null)
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
			if (is_null($month_selected))
			{
				if (count($measuring_months))
				{
					$month_selected = array_values($measuring_months)[0];
				}
				else
				{
					$month_selected = \Date::forge(time())->format("%m/%Y");
				}
			}

			$data['month_selected'] = $month_selected;

			// Get measuring data
			$data['measuring_values'] = \Model_Measuring_Value::query()
				->where('measuring_point_id', $id)
				->order_by('created_at', 'desc')
				->from_cache(false)
				->get();

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