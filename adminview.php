<?php
session_start();
$loggedin = false;
$subd = "/kidsacademy";
require_once($_SERVER['DOCUMENT_ROOT'].$subd."/utilities.php");
require_once($_SERVER['DOCUMENT_ROOT'].$subd."/includes/lang.php");
require_once($_SERVER['DOCUMENT_ROOT'].$subd."/includes/sessioncontrol.php");
?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>Kids' Academy Testsite Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?php include_once($_SERVER['DOCUMENT_ROOT'].$subd."/template/css.php"); ?>
    <?php include_once($_SERVER['DOCUMENT_ROOT'].$subd."/template/js.php"); ?>
  </head>
  <body id="index" class="home">
      <?php
      //include the header template
      include_once($_SERVER['DOCUMENT_ROOT'].$subd."/template/header.php");

      if ($loggedin){
          if($power >= 2){
              //include the admin navigation template
              include_once($_SERVER['DOCUMENT_ROOT'].$subd."/template/nav_admin.php");
          } ?>
      <section class="body">
    <?php include_once($_SERVER['DOCUMENT_ROOT'].$subd."/template/feedback.php");?>
          <?php echo $lang->greeting . " " . $User->getName() . " (" . $User->getEmail() . ") "; ?>
          <a href="auth.php?act=logout"><?php echo $lang->logout; ?></a>
      </p>
      <?php
        if($power >= 2){
            switch($_REQUEST["type"]){
                case "users":
                    $result = $User->listUsersNicely();
                        ?><table class="managegrid">
                        <tr><th><?php echo $lang->id;?></th><th><?php echo $lang->name;?></th><th><?php echo $lang->display_name;?></th><th><?php echo $lang->group;?></th><th><?php echo $lang->contact_number;?></th><th><?php echo $lang->lastlogin;?></th><th><?php echo $lang->manage;?></th></tr><?php
                        if(mysql_num_rows($result) > 0){
                                while($row = mysql_fetch_assoc($result)){
                                        ?><tr><td><?=$row["id"];?></td><td><?=$row["user_name"];?></td><td><?=$row["user_displayname"];?></td><td><?=$row["group_name"];?></td><td><?=$row["contact_number"];?></td><td><?=ago($row["last_logged_in"]);?></td><?=mo($_REQUEST["type"], $row["id"], $lang);?></tr><?
                                }
                        } else {
                                ?><tr><td colspan='9'><?php echo $lang->none_found;?></td></tr><?
                        }
                ?></table>
                <a href="adminedit.php?type=<?php echo $_GET["type"];?>&id=new"><?php echo $lang->create_user;?></a>
                <?php
                break;
                case "groups":
                    $UserGroup = new UserGroup();
                    $result = $UserGroup->listUserGroups();
                       ?>
                    <table class="managegrid">
                    <tr><th><?php echo $lang->id;?></th><th><?php echo $lang->group;?></th><th><?php echo $lang->power;?></th><th><?php echo $lang->manage;?></th></tr><?php
                    if(mysql_num_rows($result) > 0){
                            while($row = mysql_fetch_assoc($result)){
                                    ?><tr><td><?=$row["id"];?></td><td><?=$row["name"];?></td></td><td><?=$row["power"];?></td><?=mo($_REQUEST["type"], $row["id"], $lang);?></tr><?php
                            }
                    } else {
                            ?><tr><td colspan='4'><?php echo $lang->none_found;?></td></tr><?php
                    }
                    ?></table>
                    <a href="adminedit.php?type=<?php echo $_REQUEST["type"];?>&id=new"><?php echo $lang->create_group;?></a>
                <?php
                break;
            }
        } else {
            echo "<p>" . $lang->no_permission . $power . "</p>";
        }
      } else { ?>
            <h3><?php echo $lang->login; ?></h3>
            <section class="login">
		<form action="auth.php" method="post">
                    <input type="hidden" value="login" id="act" name="act" />
                    <label for="email"><?php echo $lang->email;?>: </label>
                    <input id="email" name="email" type="email"/>
                    <label for="password"><?php echo $lang->password;?>: </label>
                    <input id="password" name="password" type="password" />
                    <label for="submit"> </label>
                    <input class="submit" id="submit" name="submit" type="submit" value="<?php echo $lang->login; ?>" />
                </form>
            </section>
            <p><?php
            echo $lang->or; ?> <a href="register.php"><?php
            echo $lang->register;
            ?></a></p>
<?php } //end of logged out user ?>

      </section>
      <?php
      //include the footer template
      include_once($_SERVER['DOCUMENT_ROOT'].$subd."/template/footer.php"); ?>
  </body>
</html>