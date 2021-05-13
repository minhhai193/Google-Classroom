<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php';

    function connection() {
        $servername = "localhost";
        $username = "id15472119_classroom_itech";
        $password = "rhr2OOkxVm^=\%7b";
        $database = "id15472119_classroom";
        
        $conn = new mysqli($servername, $username, $password, $database);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    function exist($email) {
        $conn = connection();

        $sql = "SELECT COUNT(*) AS row FROM account WHERE email = '$email'";
        $row = $conn->query($sql);
        
        if ($row->num_rows > 0) {
            while ($r = $row->fetch_assoc()) {
                return $r["row"];
            }
        }
    }

    function token() {
        //Generate a random string
        $token = openssl_random_pseudo_bytes(4);
        
        //Convert the binary data into hexadecimal representation
        $token = bin2hex($token);
        
        return $token;
    }

    function email($email, $token){
        $GET = http_build_query(
            array(
                "email" => $email,
                "token" => $token
            )
        );

        $option = array(
            "http" => array(
                "method" => "GET",
                "header"  => "Content-Type: application/x-www-form-urlencoded",
                "content" => $GET
            )
        );

        $context = stream_context_create($option);

        $response = file_get_contents("https://iteaching.000webhostapp.com/client/email.php?email=".$email."&token=".$token, false, $context);

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'hcnghiep99@gmail.com';                 // SMTP username
            //$mail->Password   = 'jwryraesfduitesa';                   // SMTP password
            $mail->Password   = 'cciwnhmoaugisnwh';                     // SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;    
            //$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->setFrom('hcnghiep99@gmail.com', 'iTech Contact Team');
            //Recipients
            $mail->addAddress($email);                                  // Add a recipient
            /* $mail->addAddress('ellen@example.com');                  // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com'); */

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       // Optional name

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Verify your email address';
            $mail->Body    = $response;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function email_add_people($user_id, $receiver, $sender, $email_lecture, $classroom_id, $email, $classroom_name){
        $GET = http_build_query(
            array(
                "user_id" => $user_id,
                "receiver" => $receiver,
                "sender" => $sender,
                "email_lecture" => $email_lecture,
                "classroom_id" => $classroom_id,
                "email" => $email,
                "name" => $classroom_name
            )
        );

        $option = array(
            "http" => array(
                "method" => "GET",
                "header"  => "Content-Type: application/x-www-form-urlencoded",
                "content" => $GET
            )
        );

        $context = stream_context_create($option);

        $response = file_get_contents("https://iteaching.000webhostapp.com/client/email_add_user.php?".$GET, false, $context);

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'hcnghiep99@gmail.com';        // SMTP username
            $mail->Password   = 'cciwnhmoaugisnwh';                     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->setFrom('iteach.tdtu.contact@gmail.com', 'iTech Contact Team');
            //Recipients
            $mail->addAddress($email);                                  // Add a recipient
            /* $mail->addAddress('ellen@example.com');                  // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com'); */

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       // Optional name

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Class invitation';
            $mail->Body    = $response;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function email_send($email, $email_lecture, $name, $content) {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'hcnghiep99@gmail.com';        // SMTP username
            $mail->Password   = 'cciwnhmoaugisnwh';                     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->setFrom($email_lecture, utf8_decode($name));
            //Recipients
            $mail->addAddress($email);                                  // Add a recipient
            /* $mail->addAddress('ellen@example.com');                  // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com'); */

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       // Optional name

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = '';
            $mail->Body    = $content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function register($name, $email, $username, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = token();
        
        $sql = "INSERT INTO account(username, password, email, name, token) VALUES(?, ?, ?, ?, ?)";

        $conn = connection();
        $statement = $conn->prepare($sql);
        $statement->bind_param("sssss", $username, $password_hash, $email, $name, $token);

        if (!$statement->execute()) {
            return 1;
        }

        email($email, $token);
        return 0;
    }

    function active($email, $token){
        $conn = connection();

        $sql = "SELECT * FROM account WHERE email = '$email' AND token = '$token' AND active = 0";
        $row = $conn->query($sql);

        if ($row->num_rows > 0) {
            $sql = "UPDATE account SET active = 1 WHERE email = '$email' AND token = '$token'";

            if ($conn->query($sql) == TRUE) {
                return 0;
            }
            else {
                return 1;
            }
        }
        else {
            return 1;
        }
    }

    function login($username, $password){
        $conn = connection();

        $sql = "SELECT * FROM account WHERE username = '$username' AND active = 1";
        $rows = $conn->query($sql);

        if ($rows->num_rows > 0) {
            while ($row = $rows->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    return 0;
                }
                else {
                    return 1;
                }
            }
        }
        else {
            return 1;
        }
    }

    function get_classroom_description($classroom_id) {
        $conn = connection();

        $sql="SELECT * FROM classroom WHERE classroom_id = '$classroom_id'";
        $rows = $conn->query($sql);

        foreach($rows as $row) {
            ?>
            <div class="card">
                <img class="card-img-top" src="../img/course.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?=$row['name']?></h5>
                </div>
            </div>

            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Course details</li>
                
                    <div>
                    <p><?=$row['description']?></p>

                    <ul class="list-group list-group-flush list-details">
                        <li class="list-group-item"><span>Course code</span> <span></span> <span><?=$row['classroom_id']?></span> </li>
                        <li class="list-group-item"><span>Lecture</span> <span></span> <span><?=$row['user_name']?></span> </li>
                        <li class="list-group-item"><span>Staring date</span> <span></span> <span><?= date('D d, Y', strtotime($row['staring_date']))?></span> </li>
                    </ul>
                    </div>
                </ul>
            </div>
            <?php
        }
    }

    function get_people($classroom_id, $email, $name, $role) {
        $conn = connection();
        
        if ($role == 1) {
            $sql="SELECT account.user_id, name, email, role, passed FROM account, people WHERE account.user_id = people.user_id and people.classroom_id = '$classroom_id' order by role, passed";
            $rows = $conn->query($sql);
        }
        else {
            $sql="SELECT account.user_id, name, email, role, passed FROM account, people WHERE account.user_id = people.user_id and people.classroom_id = '$classroom_id' AND passed=1 order by role, passed";
            $rows = $conn->query($sql);
        }

        $no = 1;
        foreach($rows as $row) {
            $user_id =  $row["user_id"];
            ?>
            <tr class="filter_people">
                <td><?php if ($no < 10) { echo "0".$no; } else { echo $no; } ?></td>
                <td><?= $row["name"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?php if($row["role"] == 2) { ?> Student <?php } else {?> Lecture <?php } ?></td>
                <td>
                    <?php if ($row["passed"] == 1) {?> 
                    <div id="flex">
                        <button class="btn btn-primary" <?php if ($row["email"] == $email) {?> hidden <?php } else { ?> data-toggle="modal" data-target="#mail" data-email="<?=$row['email']?>" data-email_lecture="<?=$email?>" data-name="<?=$name?>" <?php } ?>>Mail</button>
                        <button class="btn btn-danger" <?php if(($role == 2)) { ?> hidden <?php } else if ($row["email"] == $email) {?> hidden <?php }?> data-toggle="modal" data-target="#people_delete" data-name="<?= $row['name']; ?>" data-user_id="<?=$user_id?>" data-classroom_id="<?=$classroom_id?>" data-email="<?=$email?>">Delete</button>
                    </div>
                    <?php }?> 
                </td>
                <td>
                    <div id="flex">
                        <button class="btn btn-success btn_accept" <?php if(($row["passed"] == 1) or ($row["passed"] == 2)) { ?> hidden <?php } ?> onclick="accept('<?= $classroom_id; ?>', '<?= $user_id; ?>');">Accept</button>
                        
                        <button class="btn btn-danger" <?php if(($row["passed"] == 1) or ($row["passed"] == 2)) { ?> hidden <?php } ?> onclick="reject('<?= $classroom_id; ?>', '<?= $user_id; ?>', '<?= $email; ?>');">Reject</button>
                    </div> 
                </td>
            </tr>
            <?php
            $no++;
        }
    }

    function get_dashboard($user_id) {
        $conn = connection();

        $sql="SELECT * FROM classroom WHERE classroom_id IN (SELECT classroom_id FROM people WHERE user_id = $user_id)";
        $rows = $conn->query($sql);

        foreach($rows as $row) {
            $passed = get_passed($row["classroom_id"], $user_id);

            if ($passed == 1) {
            ?>
                <div class="col-lg-3 col-md-6 col-12 col-sm-6">
                    <a href="classroom.php?course=<?=$row['classroom_id']?>">
                        <div class="card">
                            <img class="card-img-top" src="../img/course.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title text-truncate"><?= $row["name"]; ?></h5>
                                <p class="card-text"><?=$row["user_name"] ?></p>
                                <?php if (get_role($user_id) == 1) { ?>
                                    <button class="btn btn-danger float-right" data-toggle="modal" data-target="#delete_course" data-user_id="<?=$row['user_id']?>" data-name="<?=$row['name']?>" data-classroom_id="<?=$row['classroom_id']?>" onclick="return false;">Delete</button>
                                    <button class="btn btn-success float-right mr-2" data-toggle="modal" data-target="#edit_course" data-name="<?=$row['name']?>" data-classroom_id="<?=$row['classroom_id']?>" data-description="<?=$row['description']?>"  data-staring_date="<?=$row['staring_date']?>" data-lecture="<?=get_name($user_id);?>" data-user_id="<?=$user_id?>" onclick="return false;">Edit</button>
                                <?php } ?>  
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            else {
            ?>
                <div class="col-lg-3 col-md-6 col-12 col-sm-6">
                    <div class="card">
                        <div id="status-class">
                            <img class="card-img-top" src="../img/course.jpg" alt="Card image cap">
                            <div>
                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                <lottie-player src="https://assets3.lottiefiles.com/datafiles/riuf5c21sUZ05w6/data.json"  background="transparent"  speed="1"  style="width: 100px; height: 100px;"  loop  autoplay></lottie-player>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= $row["name"]; ?></h5>
                            <p class="card-text"><?=$row["user_name"] ?></p>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }

    function get_passed($classroom_id, $user_id){
        $conn = connection();
        $sql="SELECT passed FROM people WHERE classroom_id = '$classroom_id' and user_id = $user_id";
        $passed = $conn->query($sql);
        $passed = mysqli_fetch_assoc($passed);

        return  $passed['passed'];
    }

    function get_role($user_id){
        $conn = connection();
        $sql = "SELECT role FROM account WHERE user_id = $user_id";
        $result = $conn->query($sql);
        $result = mysqli_fetch_assoc($result);

        return  $result['role'];
    }

    function get_name($user_id){
        $conn = connection();
        $sql = "SELECT name FROM account WHERE user_id = $user_id";
        $result = $conn->query($sql);
        $result = mysqli_fetch_assoc($result);

        return  $result['name'];
    }

    function get_component($classroom_id, $role, $type, $user_id) {
        $conn = connection();

        if ($type == 2) {
            $sql="SELECT * FROM component WHERE type=2 AND classroom_id='$classroom_id' ORDER BY component_id DESC";
            $rows = $conn->query($sql);
            
            $no = 1;
            foreach($rows as $row) {
                ?>
                <tr class="filter_assignment">
                    <td>
                        <?php
                            if ($no <= 9) {
                                echo "0" . $no;
                            }
                            else {
                                echo $no;
                            }
                        ?>
                    </td>
                    
                    <td> <a href="submit.php?course=<?=$classroom_id?>&component_id=<?= $row['component_id']; ?>"><?= $row["title"]; ?></a> </td>

                    <td>
                        <?= date('d/m/Y h:i A', strtotime($row['deadline']))?>
                    </td>

                    <?php 
                        $today = date("Y-m-d"); 
                        $deadline =  $row["deadline"];
                        
                        $today_time = strtotime($today); 
                        $deadline_time = strtotime($deadline); 
                        $datedis = floor(abs($today_time - $deadline_time) / (60*60*24));

                        if ($row["submission"] == "") {                                            
                            if ($today_time > $deadline_time) {
                                echo "<td class='text-danger'>Missing</td>";
                            } elseif ($datedis <= 7) {
                                echo "<td class='text-warning'>Deadline</td>";
                            }else {
                                echo "<td>To-do</td>";
                            }
                        }else {
                            echo "<td class='text-success'>Success</td>";
                        }                           
                    ?>

                    <td>
                        <?php
                            $component_id = $row["component_id"];
                            $submission = "SELECT * FROM submission WHERE component_id=$component_id AND classroom_id='$classroom_id' AND user_id=$user_id";
                            $files = $conn->query($submission);
                            // $file = $files->fetch_assoc(); 
                            if (mysqli_num_rows($files) == 0) {
                                echo "-";
                            } else {
                                $file = mysqli_fetch_assoc($files);
                                echo "<a href='https://docs.google.com/gview?url=https://iteaching.000webhostapp.com/client/uploads/". $file["file"]. "&embedded=true' target='_blank'>". $file["file"] . "</a>";
                            }
                        ?>
                    </td>

                    <td <?php if($role == 2) { ?> hidden <?php } ?>>
                        <div id="flex">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#edit" data-classroom_id="<?=$classroom_id?>" data-component_id="<?=$row['component_id']?>" data-title="<?=$row['title']?>" data-details="<?=$row['content']?>" data-date="<?= date('Y-m-d\TH:i', strtotime($row['deadline']))?>">Edit</button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#assignment_delete" data-classroom_id="<?=$classroom_id?>" data-component_id="<?=$row['component_id']?>" data-title="<?=$row['title']?>">Delete</button>
                        </div> 
                    </td>
                </tr>
                <?php
                $no += 1;
            }
        }
        else {
            $sql="SELECT * FROM component WHERE classroom_id='$classroom_id' ORDER BY component_id DESC";
            $rows = $conn->query($sql);

            foreach($rows as $row){
                $get_name = get_name($row['user_id']);
                //$get_name = $get_name->fetch_assoc();

                if ($row["type"] == 1) {
                    ?>
                    <div class="col-12">
                        <div class="card">
                            <div id="flex">
                                <img src="../img/photo.png" alt="No image found">
                                <div>
                                    <h6><?= $get_name ?></h6>
                                    <p><?= date('M d, Y h:i A', strtotime($row['timeline'])) ?></p>
                                </div>
                                <span id="flx"></span>
                                <?php if ($role == 1) {?>
                                    <div id="flex">
                                        <i class="fal fa-edit" data-toggle="modal" data-target="#edit_component" data-user_id="<?=$row['user_id']?>" data-component_id="<?=$row['component_id']?>" data-classroom_id="<?=$row['classroom_id']?>" data-content="<?=$row['content']?>"></i>
                                        <i class="fal fa-times" data-toggle="modal" data-target="#delete_component" data-user_id="<?=$row['user_id']?>" data-component_id="<?=$row['component_id']?>" data-classroom_id="<?=$row['classroom_id']?>"></i>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="card-body">
                                <p><?= htmlspecialchars_decode($row['content']); ?></p>
                                <a href="" class="btn btn-comment" data-toggle="modal" data-target="#comment" data-classroom_id="<?=$classroom_id?>" data-component_id="<?= $row['component_id'] ?>" data-user_id="<?= $user_id ?>" data-role="<?=$role?>">Class comments</a>
                                <a href="" class="btn btn-material" data-toggle="modal" data-target="#material" data-classroom_id="<?=$classroom_id?>" data-component_id="<?= $row['component_id'] ?>">View materials</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                elseif ($row["type"] == 2) {
                    ?>
                    <div class="col-12">
                        <div class="card" id="assignment">
                            <a href="submit.php?course=<?=$row['classroom_id']?>&component_id=<?=$row['component_id']?>">
                                <div id="flex">
                                    <img src="../img/icon.jpg" alt="No image found">
                                    <div id="flx">
                                        <h6><?= $row["title"]; ?></h6>
                                        <p><?= date('M d, Y h:i A', strtotime($row['timeline'])) ?></p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <a href="" class="btn btn-comment" data-toggle="modal" data-target="#comment" data-classroom_id="<?=$classroom_id?>" data-component_id="<?= $row['component_id'] ?>" data-user_id="<?= $user_id ?>" data-role="<?=$role?>">Class comments</a>
                                    <a href="" class="btn btn-material" data-toggle="modal" data-target="#material" data-classroom_id="<?=$classroom_id?>" data-component_id="<?= $row['component_id'] ?>">View materials</a>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    }
    
    function get_AssignmentSubmit($component_id, $classroom_id){
        $conn = connection();

        $sql="SELECT * FROM component WHERE component_id = $component_id AND classroom_id = '$classroom_id'";
        $rows = $conn->query($sql);

        return $rows;
    }

    function get_AssignmentSubmitFile($component_id, $classroom_id){
        $conn = connection();

        $sql="SELECT * FROM component WHERE component_id = $component_id AND classroom_id = '$classroom_id'";
        $rows = $conn->query($sql);

        return $rows;
    }

    // function get_name($user_id) {
    //     $conn = connection();

    //     $sql="SELECT name FROM account WHERE user_id = $user_id";
    //     $rows = $conn->query($sql);

    //     return $rows;
    // }

    function random($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $random = '';
	    for ($i = 0; $i < $length; $i++) {
	        $random .= $characters[Rand(0, strlen($characters) - 1)];
	    }
	    return $random;
	}
?>