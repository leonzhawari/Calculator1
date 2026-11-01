<?php
session_start();

//session protection
if(!isset($_SESSION['logged_in'])|| $_SESSION['logged_in'] !== true)
{
    header("Location: login.php");
    exit();
}

//function to calculate total and average
function CalculateResults($marks)
{
    $total= array_sum($marks);
    $average=$total / count($marks);
    return[$total , $average];
}

//function to get grade from average
function getGrade($avg)
{
    if($avg >=80) 
        return "A";
    elseif($avg >=70)
        return "B";
    elseif($avg >=60)
        return "C";
    elseif($avg >=50)
        return "D";
    else
        return "F";

}
$result=null;
$errors=[];

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name=trim($_POST['student_name']);
        $marks=[
            'OOP'=>$_POST['oop'],
            'Web_tech'=>$_POST['web_tech'],
            'Data_comms'=>$_POST['data_comms'],
            'Data_Structures&Alg'=>$_POST['data_structures']

        ];

        //validation
        if(empty($name))
            {
                $errors[]="Pliz fill , student name can't be empty";
            }

        foreach($marks as $subject=>$mark)
            {
                if(!is_numeric($mark) || $mark < 0 || $mark >100)
                    {
                        $errors[]= "$subject mark must be  between 0 and 100";
                    }
            }

            if (empty($errors))
                {
                     list($total , $average)=CalculateResults($marks);
                     $grade=getGrade($average);
                     $result=[
                       'name'=>$name,
                       'marks'=>$marks,
                       'total'=>$total,
                       'average'=>$average,
                       'grade'=> $grade

                     ];   
                    
                }
    
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calculator</title>

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Welcome , <?php echo $_SESSION['username']; ?> | <a href="login.php"> Logout</a></h2>
        <h3>Student grade calculator</h3>

        <form method="POST">
            Student Name :<input type= "text" name="student_name" required><br> <br>
            OOP :<input type= "number" name="oop" required><br><br>
            Web_tech :<input type= "number" name="web_tech" required><br><br>
            Data_comms :<input type= "number" name="data_comms" required><br><br>
            Data_Structures&Alg :<input type= "number" name="data_structures" required><br><br>
            <input type="submit" value= Calculate>
        </form>

        <?php
        if(!empty($errors))
        {
            foreach($errors as $e)
                {
                    echo "<p style='color :red;'>$e</p>";
                }
        }

        if($result)
            {
                echo "<h3>Result</h3>";
                echo "<table border-'1' cellpadding='8' <tr><th>Name</th><th>Subject</th>Mark</th></tr> <tr><td rowspan='5'>{$result['name']},</td></tr>";

                foreach($result['marks'] as $sub=>$mk)
                    {
                        echo "<tr><td>$sub</td><td>$mk</td></tr>";
                    }
                    echo "</table><br>";
                    echo "<table border='1' cellpadding='8'>
                    <tr><th>Total</th><th>Average</th><th>Grade</th></tr><tr><td>{$result['total']}</td><td>".number_format($result['average'],2)." </td><td>{$result['grade']}</td></tr>

                    </table>";
            }

        ?>
    </body>
    </html>


