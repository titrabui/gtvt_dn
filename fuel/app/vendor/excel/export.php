<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../excel/PHPExcel.php';

Class Excel {

	public static function export($measuring_values, $month_selected)
	{
		try
		{
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()
				->setCreator("Sở giao thông vận tải Đà Nẵng")
				->setLastModifiedBy("Sở giao thông vận tải Đà Nẵng")
				->setTitle("Báo cáo giá trị đo");

			// Set title header
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'STT')
				->setCellValue('B1', 'Ngày')
				->setCellValue('C1', 'Thời gian')
				->setCellValue('D1', 'Tổng thời gian khảo sát (ngày)')
				->setCellValue('E1', 'Nhiệt độ bên ngoài (℃)')
				->setCellValue('F1', 'Nhiệt độ vị trí 1 dưới kết cấu (℃)')
				->setCellValue('G1', 'Nhiệt độ vị trí 2 dưới kết cấu (℃)');

			// Add excel data
			$index = 1;
			$row = 2;
			foreach ($measuring_values as $item)
			{
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, $index++)
					->setCellValue('B'.$row, Date::forge($item['created_at'])->format("%d - %m - %Y"))
					->setCellValue('C'.$row, Date::forge($item['created_at'])->format("%H : %M : %S"))
					->setCellValue('D'.$row, $item['total_time_surveying'])
					->setCellValue('E'.$row, $item['value1'])
					->setCellValue('F'.$row, $item['value2'])
					->setCellValue('G'.$row, $item['value3']);
				$row++;
			}

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle($month_selected);

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Báo cáo tháng '.$month_selected.'".xlsx"');
			header('Cache-Control: max-age=0');

			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}
		catch (\Exception $e)
		{
			// redirect to error page
			Session::set_flash('error', array('message' => $e->getMessage()));
			Response::redirect('admin/error');
		}
	}
}
