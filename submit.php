<?php
// معلومات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "application form"; // تأكد من استخدام underscore بدلاً من space في اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من وجود بيانات تم إرسالها من النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الحصول على البيانات من الفورم
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $date = $_POST['date'];
    $salary = $_POST['salary'];
    $employmentStatus = $_POST['employmentStatus'];
    $highschool = $_POST['highschool'];
    $college = $_POST['college'];
    $grade = $_POST['grade'];
    $major = $_POST['major'];
    $training = $_POST['training'];
    $training2 = $_POST['training2'];
    $employed1 = $_POST['employed1'];
    $companyname1 = $_POST['companyname1'];
    $location1 = $_POST['location1'];
    $role1 = $_POST['role1'];
    $message1 = $_POST['message1'];
    $nationalId = $_POST['nationalId'];
    $fullName = $_POST['fullName'];

    // استخدام جملة تحضيرية لتجنب SQL Injection
    $stmt = $conn->prepare("INSERT INTO form_data (
        firstName, 
        lastName, 
        address, 
        email, 
        phone, 
        position, 
        startDate, 
        salary, 
        employmentStatus, 
        highschool, 
        college, 
        grade, 
        major, 
        training, 
        otherEducation, 
        employed1, 
        companyName1, 
        location1, 
        role1, 
        jobTasks, 
        nationalId, 
        fullName 
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // ربط المتغيرات مع المعلمات
    $stmt->bind_param("ssssssssssssssssssssss", 
        $firstName, 
        $lastName, 
        $address,
        $email,
        $phone,
        $position,
        $date,
        $salary,
        $employmentStatus,
        $highschool,
        $college,
        $grade,
        $major,
        $training,
        $training2,
        $employed1,
        $companyname1,
        $location1,
        $role1,
        $message1,
        $nationalId,
        $fullName
    );

    // تنفيذ الاستعلام والتحقق من نجاح العملية
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Data has been successfully saved.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Data </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #52107a;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<h1>  All Data</h1>

<?php
// استعلام لاسترجاع البيانات من جدول form_data
$sql = "SELECT * FROM form_data";
$result = $conn->query($sql);

// التحقق من وجود نتائج
if ($result->num_rows > 0) {
    // عرض البيانات في جدول HTML
    echo "<table>
            <tr>
                <th>First Name</th>
                <th> Last Name</th>
                <th>Email</th>
                <th> Addres</th>
                <th> Phone</th>
                <th>position</th>
                <th> Start Date</th>
                <th>Salary</th>
                <th>Employment Status </th>
                <th>High School</th>
                <th>College</th>
                <th>Grade</th>
                <th>Major</th>
                <th>Training</th>
                <th> Other education</th>
                <th>Employment Date </th>
                <th>Company Name</th>
                <th>Location</th>
                <th>Role</th>
                <th>Message</th>
                <th>National ID</th>
                <th>Full Name</th>
            </tr>";
    // عرض البيانات في كل صف
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["firstName"] . "</td>
                <td>" . $row["lastName"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["address"] . "</td>
                <td>" . $row["phone"] . "</td>
                <td>" . $row["position"] . "</td>
                <td>" . $row["startDate"] . "</td>
                <td>" . $row["salary"] . "</td>
                <td>" . $row["employmentStatus"] . "</td>
                <td>" . $row["highschool"] . "</td>
                <td>" . $row["college"] . "</td>
                <td>" . $row["grade"] . "</td>
                <td>" . $row["major"] . "</td>
                <td>" . $row["training"] . "</td>
                <td>" . $row["otherEducation"] . "</td>
                <td>" . $row["employed1"] . "</td>
                <td>" . $row["companyName1"] . "</td>
                <td>" . $row["location1"] . "</td>
                <td>" . $row["role1"] . "</td>
                <td>" . $row["jobTasks"] . "</td>
                <td>" . $row["nationalId"] . "</td>
                <td>" . $row["fullName"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No data to show</p>";
}

// إغلاق الاتصال
$conn->close();
?>

</body>
</html>
