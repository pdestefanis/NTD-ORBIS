<?php
    class GoogleChartHelper extends AppHelper
    {
		/**
         * org chart
         */
        public function orgChart($rows, $columns, $values, $width, $height, $title, $hAxis)
        {
            $chart = '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">
                  google.load("visualization", "1", {packages:["orgchart"]});
                  google.setOnLoadCallback(drawChart);
                  function drawChart() {
                    var data = new google.visualization.DataTable();';

            // column must be in multidimensional array
            if (is_array($columns)) {
                foreach ($columns as $column) {
                    if (is_array($column)) {
                        $chart .= "data.addColumn(\"$column[type]\", \"$column[value]\");";
                    }
                }
            }
            // row
            if (is_int($rows)) {
                $chart .= "data.addRows($rows);";
            }
     
            // values
            if (is_array($values)) {
     
                $row = 0;
                $column_count = 0;
                foreach ($columns as $column) {
                    $column_count += count($column['value']);
                }
                $column = 0;
                foreach ($values as $value) {
                    for ($i = 0; $i < count($value)-1; $i++) {
                        if ($row <= $rows) {

                            if ($column === $column_count) {
                                $column = 0;
                            }
							
                            if ($column <= $column_count) {
                                if (is_array($value)) {
									if ($column == 1 && empty($value[$i])) {
										$column++;
										continue; //skip top element parent
									}
									if ($column == 0) {
										$chart .= "data.setCell(" . $row . "," . $column . ",'" . $value[$i] ; //. "');";	
										$chart .= "', '" . $value[$i] . "<br/>" . $value[3] . "');";
									} else 
										$chart .= "data.setCell(" . $row . "," . $column . ",'" . $value[$i] . "');";
									
                                    /* if ($column == 0 || $column == 1 || $column == 2) {
                                        $chart .= "data.setCell(" . $row . "," . $column . ",\"" . $v . "\");";
                                    } else {
                                        $chart .= "data.setCell(" . $row . "," . $column . "," . $v . ");";
                                    } */
                                }
                            }
                            $column++;
                        }
     
                    }
                    $row++;
                }
     
            }
            if (empty($width)) {
                $width = 800;
            }
            if (empty($height)) {
                $height = 600;
            }
            if (empty($title)) {
                $title = "Column Chart Test";
            }
            if (empty($hAxis)) {
                $hAxis = "hAxis Label";
            }
            $chart .= 'var chart = new google.visualization.OrgChart(document.getElementById("chart_div"));
                    chart.draw(data,
                    {
                        width: ' . $width . ',
                        height: ' . $height . ',
                        title: "' . $title . '",
                        hAxis: {title: "' . $hAxis . '" },
						size: "medium",
						allowCollapse: true,
						allowHtml: true
                    });
                  }
                </script>
                <div id="chart_div" style="height: ' . $height .'; width: ' .$width . '"></div>
                </div>';
     
            return $chart;
     
        }
		
        /**
         * column chart
         */
        public function columnChart($rows, $columns, $values, $width, $height, $title, $hAxis)
        {
     
     
            $chart = '
                <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                <script type="text/javascript">
                  google.load("visualization", "1", {packages:["corechart"]});
                  google.setOnLoadCallback(drawChart);
                  function drawChart() {
                    var data = new google.visualization.DataTable();
            ';
     
     
            // column must be in multidimensional array
            if (is_array($columns)) {
                foreach ($columns as $column) {
                    if (is_array($column)) {
                        $chart .= "data.addColumn(\"$column[type]\", \"$column[value]\");";
                    }
                }
            }
     
            // row
            if (is_int($rows)) {
                $chart .= "data.addRows($rows);";
            }
     
            // values
            if (is_array($values)) {
     
                $row = 0;
                $column_count = 0;
                foreach ($columns as $column) {
                    $column_count += count($column['value']);
                }
                $column = 0;
                foreach ($values as $value) {
                    foreach ($value as $v) {
     
                        if ($row <= $rows) {
     
                            if ($column === $column_count) {
                                $column = 0;
                            }
                            if ($column <= $column_count) {
                                if (is_array($value)) {
                                    if ($column == 0) {
                                        $chart .= "data.setValue(" . $row . "," . $column . ",\"" . $v . "\");";
                                    } else {
                                        $chart .= "data.setValue(" . $row . "," . $column . "," . $v . ");";
                                    }
                                }
                            }
                            $column++;
                        }
     
                    }
                    $row++;
                }
     
            }
     
            if (empty($width)) {
                $width = 800;
            }
     
            if (empty($height)) {
                $height = 600;
            }
     
            if (empty($title)) {
                $title = "Column Chart Test";
            }
     
            if (empty($hAxis)) {
                $hAxis = "hAxis Label";
            }
     
            $chart .= '
                    var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
                    chart.draw(data,
                    {
                        width: ' . $width . ',
                        height: ' . $height . ',
                        title: "' . $title . '",
                        hAxis: {title: "' . $hAxis . '" }
                    });
                  }
                </script>
                <div id="chart_div" style="height: 200px; width: 400px"></div>
                Loading...
                </div>
            ';
     
            return $chart;
        }
    }
?>