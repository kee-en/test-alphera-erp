<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Alphera ERP Global Applicant Report</title>
		<link href="assets/css/r_global_applicant_report.css" rel="stylesheet" type="text/css" />
	</head>
	<body id="r_global_applicant_report" lang="en-US">
		<div id="_idContainer000" class="Basic-Text-Frame">
			<table id="table001" class="Basic-Table _idGenTablePara-1">
				<colgroup>
					<col class="_idGenTableRowColumn-1" />
					<col class="_idGenTableRowColumn-2" />
					<col class="_idGenTableRowColumn-3" />
					<col class="_idGenTableRowColumn-4" />
					<col class="_idGenTableRowColumn-5" />
					<col class="_idGenTableRowColumn-6" />
					<col class="_idGenTableRowColumn-7" />
					<col class="_idGenTableRowColumn-8" />
					<col class="_idGenTableRowColumn-9" />
					<col class="_idGenTableRowColumn-10" />
					<col class="_idGenTableRowColumn-11" />
					<col class="_idGenTableRowColumn-12" />
				</colgroup>
				<tbody>
					<tr class="Basic-Table _idGenTableRowColumn-13">
						<td class="Basic-Table CellOverride-1">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">ID</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Applicant ID</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Full Name</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Address</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">First </span></p>
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Position</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Second </span></p>
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Position</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Approved </span></p>
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Position</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">BMI</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Date </span></p>
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Availability</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">NAT Result</span></p>
						</td>
						<td class="Basic-Table CellOverride-2">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Application Status</span></p>
						</td>
						<td class="Basic-Table CellOverride-3">
							<p class="Basic-Paragraph ParaOverride-1"><span class="CharOverride-1">Assessed By</span></p>
						</td>
					</tr>
					<?php
					foreach ($employee_row as $row) { ?>
						<tr class="Basic-Table _idGenTableRowColumn-14">
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['applicant_no']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['applicant_code']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['fullname']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['address']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['position_1']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['position_2']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['approved_position_name']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['bmi']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['date_available']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['nat_result']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['status']?></p>
							</td>
							<td class="Basic-Table CellOverride-4">
								<p class="Basic-Paragraph ParaOverride-1"><?=$row['assessor_name']?></p>
							</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>