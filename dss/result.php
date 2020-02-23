<!DOCTYPE html>
<html lang="en">
<head>
  <title>ผลสรุป</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>
<body > 
<?php
$gender = $_POST['gender'];
$age = $_POST['age'];
$edu = $_POST['edu'];
$income = $_POST['income'];
$working = $_POST['working'];
$objective = $_POST['objective'];
$frequency = $_POST['frequency'];
$location = $_POST['location'];
$now = $_POST['now'];
$buy = $_POST['buy'];
$how = $_POST['how'];
$reason = $_POST['reason'];
$important = $_POST['important'];
$motive = $_POST['motive'];

/*echo "gender = ".$gender.'<br>';
echo "age = ".$age.'<br>';
echo "edu = ".$edu.'<br>';
echo "income = ".$income.'<br>';
echo "working = ".$working.'<br>';
echo "objective = ".$objective.'<br>';
echo "frequency = ".$frequency.'<br>';
echo "location = ".$location.'<br>';
echo "now = ".$now.'<br>';
echo "buy = ".$buy.'<br>';
echo "how = ".$how.'<br>';
echo "reason = ".$reason.'<br>';
echo "important = ".$important.'<br>';
echo "motive = ".$motive.'<br>';*/

$data = array ('Gender,Age,Education,Income,Working_hours,objective,frequency_work,Location_of_use,computer_or_notebook_for_use,Where_to_buy,How_to_buy,Reasons,choosing_to_buy,motive,class',
                'male,2,3,1,2,4,1,2,1,1,2,2,3,2,com',
                'female,1,1,3,2,3,3,1,2,2,2,2,3,2,note',
                'female,1,2,3,2,3,2,1,2,4,2,2,1,1,note',
                'male,4,2,3,1,3,3,1,2,2,1,3,1,1,com',
                'female,3,2,4,2,2,3,2,2,2,1,2,2,1,com',
                'female,2,1,4,2,2,1,1,2,5,2,2,1,1,note',
                'male,1,2,2,1,2,1,1,2,2,1,2,2,1,note',
                $gender.','.$age.','.$edu.','.$income.','.$working.','.$objective.','.$frequency.','.$location.','.$now.','.$buy.','.$how.','.$reason.','.$important.','.$motive.',?');
    $fp = fopen('comornote.csv', 'w');
    foreach($data as $line){
        $val = explode(",",$line);
        fputcsv($fp, $val);
    }
    fclose($fp);

    $cmd = 'java -classpath "weka.jar" weka.core.converters.CSVLoader comornote.csv > comornote_unseen.arff';
    exec($cmd,$output);
   

    $cmd1 = 'java -classpath "weka.jar" weka.classifiers.trees.J48 -T "comornote_unseen.arff" -l "model2.model" -p 15'; // show output prediction
    exec($cmd1,$output1);

    
    
    $show=$output1[sizeof($output1)-2];
    $sub = substr($show,-7);
    $result = $show[28].$show[29].$show[30]; 

    //echo $show." ".$result." ".$sub." ".$res.'<br>';
    
    $res = $sub*100;
    if($result == 'com'){
        $com = $res;
        $notebook = 100-$res;
    }
    else {
        $notebook = $res;
        $com = 100-$res;
    }
    //echo $result.'<br>';
   //echo $show." ".$result." ".$sub." ".$res.'<br>';
   if($com<$notebook){
    $text2 = "จากผลสรุปคุณควรที่จะซื้อ Notebook มากกว่า";
   }
   else $text2 = "จากผลสรุปคุณควรที่จะซื้อ Computer มากกว่า";


    $dataPoints = array( 
        array("label"=>"Computer", "symbol" => "Computer","y"=>$com),
        array("label"=>"Notebook", "symbol" => "Notebook","y"=>$notebook),
    );
           
?>
    <script>
        window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2",
        animationEnabled: true,
        title: {
        text: "<?php echo $text2; ?>"
        },
        data: [{
        type: "doughnut",
        indexLabel: "{symbol} - {y}",
        yValueFormatString: "#,##0.0\"%\"",
        showInLegend: true,
        legendText: "{label} : {y}",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
                
    }
    function goBack() {
        window.history.back();
    }
    </script>
     <br><br>
    <div id="chartContainer" style="height: 370px; width: 100%; " class="container"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <br><br>
  <center>
    <button type="button" class="btn btn-success" onclick="goBack()">กดเพื่อกลับหน้าแรก</button>
    </center>
    

    </body>
</html>