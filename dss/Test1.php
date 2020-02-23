<form action="" method="post">

left-weight : <input type="text" name="num1"/><br><br>
left-distance : <input type="text" name="num2"/><br><br>
right-weight : <input type="text" name="num3"/><br><br>
right-distance : <input type="text" name="num4"/><br><br>
  <input type="submit" name="submit"/>

</form>    

<?php
  
  if(isset($_POST['submit'])){
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $num3 = $_POST['num3'];
    $num4 = $_POST['num4'];

    echo 'ข้อมูลที่คุณป้อนของคุณคือ :'.$num1.' '.$num2.' '.$num3.' '.$num4.'<br><br>';

    $data = array ('left-weight,left-distance,right-weight,right-distance,class',
                            '5,1,3,2,L',
                            '4,2,3,1,B',
                            '3,2,2,1,R',
                            $num1.','.$num2.','.$num3.','.$num4.',?');
    $fp = fopen('balance_csv.csv', 'w');
    foreach($data as $line){
        $val = explode(",",$line);
        fputcsv($fp, $val);
    }
    fclose($fp);

    $cmd = 'java -classpath "weka.jar" weka.core.converters.CSVLoader balance_csv.csv > balance_unseen_test.arff ';
    exec($cmd,$output);

    $cmd1 = 'java -classpath "weka.jar" weka.classifiers.trees.J48 -T "balance_unseen_test.arff" -l "balance.model" -p 5'; // show output prediction
    exec($cmd1,$output1);

    $show=$output1[sizeof($output1)-2];
    echo '<br>ผลลัพธ์ได้จากการทำนายคือ : '.$show."<br>";
}

?>
