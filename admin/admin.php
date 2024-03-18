<?php
require __DIR__ . "../../includes/functions.php";
require __DIR__ . "../../messages/messages.php";
require __DIR__ . "../../topics/topics.php";

if (!isLoggedIn()) {
  header("Location: ../auth/login_register.php");
}

if (!isAdmin()) {
  echo "<script>alert('Admin only !');</script>";
  header("Location: ../index.php");
}

if (isset($_POST["submit_message"])) {
  sendMessage();
}

$messages = renderMessages();
$users = getAllUsers();
$topics = getTopics()

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon_white.png" type="image/x-icon">
  <title>Collaborate Solutions | Admin Space</title>
</head>

<body>
  <nav class="main-menu">
    <ul>
      <a href="../index.php">
        <img width="60%" src="../images/favicon_white.png" alt="logo">
      </a>
      <a href="../index.php">
        <li class="menu-item">
          <i class="fa fa-home"></i>Home
        </li>
      </a>
      <a href="../profile/profile_user.php">
        <li class="menu-item">
          <i class="fa fa-user-circle-o"></i>Profile
        </li>
      </a>
      <?php if (isAdmin()): ?>
        <a href="admin.php">
          <li class="menu-item">
            <i class="fa fa-shield fa-lg"></i>Admin Space
          </li>
        </a>
      <?php endif; ?>
    </ul>
    <ul class="logout">
      <a id="open-popup-message-sidebar">
        <li class="menu-item">
          <i class="fa fa-question-circle-o"></i>Help
        </li>
      </a>
      <a href="../auth/logout.php">
        <li class="menu-item">
          <i class="fa fa-sign-out"></i>Logout
        </li>
      </a>
    </ul>
  </nav>

  <div class="popup" id="popup-message">
    <div class="overlay"></div>
    <form class="popup-content" action="admin.php" method="post" autocomplete="off">
      <h2>Message us</h2>
      <div class="input-create-topic">
        <input class="edit-input" type="text" name="title_message" id="title_message" required placeholder="Title*">
        <input class="edit-input" type="text" name="content_message" id="content_message" required placeholder="Content*">
      </div>
      <div class="controls">
        <button class="close-btn">Close</button>
        <button type="submit" name="submit_message" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>

  <section id="content">
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Admin Space</h1>
				</div>
			</div>
      
      <h3>Messages from Users</h3>

			<ul class="box-info">
        <?php foreach ($messages as $message): ?>
          <li>
            <span class="text">
              <h3><?php echo $message["message_title"]?></h3>
              <p>Sent by: <?php echo $message["message_creator"] ?></p>
              <hr>
              <p class="text-content"><?php echo $message["message_content"] ?></p>
              <form method="post"
                action="../messages/delete_message.php?message_id=<?php echo $message['message_id']; ?>">
                <button type="submit" class="button-management delete" style="margin-top: 20px;">Delete</button>
              </form>
            </span>
          </li>
        <?php endforeach; ?>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Users Management</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Number</th>
                <th>User Avatar</th>
                <th>Username</th>
                <th>Email</th>
								<th>Created at</th>
                <th>Role</th>
								<th>Management</th>
							</tr>
						</thead>
						<tbody>
              <?php foreach ($users as $index => $user): ?>
                <tr>
                  <td><?php echo $index + 1; ?></td>
                  <td>
                    <img src="../images/avatars/<?php echo $user["avatar"] ?>" alt="avatar">
                  </td>
                  <td><?php echo $user['username']?></td>
                  <td><?php echo $user['email'] ?></td>
                  <td><?php echo $user['created_at'] ?></td>
                  <td><?php echo $user['role'] ?></td>
                  <td>
                    <form action="" style="display: inline-block;">
                      <button class="button-management edit">Edit</button>
                    </form>
                    <form 
                      method="post"
                      action="../profile/delete_user.php?user_id=<?php echo $user['user_id']; ?>" 
                      style="display: inline-block;"
                    >
                      <button class="button-management delete">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
						</tbody>
					</table>
				</div> 
				<div class="todo">
					<div class="head">
						<h3>Topics Management</h3>
					</div>
          <div class="order">
            <table>
						<thead>
							<tr>
								<th>Number</th>
                <th>Topic name</th>
                <th>Subscription</th>
                <th>Thumbnail</th>
								<th>Created at</th>
								<th>Management</th>
							</tr>
						</thead>
						<tbody>
              <?php foreach ($topics as $index => $topic): ?>
                  <tr>
                    <td>
                      <?php echo $index + 1; ?>
                    </td>
                    <td width="200">
                      <?php echo $topic["topic_name"] ?>
                    </td>
                    <td width="300">
                      <?php echo $topic['topic_content'] ?>
                    </td>
                    <td>
                      <?php echo $topic['topic_thumbnail'] ?>
                    </td>
                    <td>
                      <?php echo $topic['created_at'] ?>
                    </td>
                    <td>
                      <form action="" style="display: inline-block;">
                        <button class="button-management edit">Edit</button>
                      </form>
                      <form method="post" style="display: inline-block;"
                        action="../topics/delete_topic.php?topic_id=<?php echo $topic['topic_id']; ?>">
                        <button type="submit" class="button-management delete">Delete</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
					
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>

  <script src="../js/admin.js"></script>
</body>

</html>