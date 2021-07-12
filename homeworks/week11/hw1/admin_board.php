<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  
  $username = NULL;
  $user = NULL;
  // 檢查登入狀態
  if(!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }
  // 不是管理員滾回留言版
  $user_group_id = isset($user['user_group_id']) ? (int)$user['user_group_id'] : 0;
  if($user_group_id === 0 || $user_group_id > 2) {
    header("Location: index.php");
    exit;
  }
  $sql = "SELECT
  C.id AS id,
  C.username AS username,
  C.created_at AS created_at,
  C.user_group_id AS user_group_id,
  U.group_name AS group_name,
  P.enable_add,
  P.enable_edit,
  P.enable_delete
  FROM wei_users AS C
  JOIN wei_users_group AS U ON C.user_group_id = U.id
  JOIN wei_users_permission AS P ON C.user_group_id = P.user_group_id
  WHERE C.id <> 1
  ORDER BY C.id DESC";

  // $stmt = $conn->prepare($sql);
  // $stmt->bind_param("ii", $item_per_pages, $offset);
  // $result = $stmt->execute();
  $result = $conn->query($sql);

  if(!$result) {
    die("Error: " . $conn->error);
  }
  // $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>留言板</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>

<body>
  <header class="warning">
    <strong>留言板 後台</strong>
  </header>
  <main class="board">
    <?php if(!$username) { ?>
      <div>
        <a class="board__btn status__btn" href="admin_login.php">登入</a>
      </div>
    <?php } else { ?>
      <a class="board__btn logout__btn" href="logout.php">登出</a>
      <h3><strong><?php echo escape($user['nickname']); ?></strong> 您好！</h3>
      <div>
        <table class="table" style="width: 100%;">
          <thead>
            <tr>
              <td>使用者名稱</td>
              <td>使用者身分</td>
              <td>註冊日期</td>
              <td>操作</td>
            </tr>
          </thead>
          <tbody>
          <?php
            while($row = $result->fetch_assoc()) {
            $user_id = (int)$row['id'];
            $group_id = (int)$row['user_group_id'];
          ?>
            <tr>
              <td><?php echo escape($row['username']); ?></td>
              <td><?php echo escape($row['group_name']); ?></td>
              <td><?php echo escape($row['created_at']); ?></td>
              <?php if($user_group_id === 1 || $group_id !== 2) { ?>
              <td>
              <?php if($user_group_id === 1 || $group_id === 2) { ?>
                <button value="2" data-user-id="<?php echo $user_id ?>" data-group-id="<?php echo $group_id ?>" class="btn"><i class="fa fa-ban"></i> 管理員</button>
              <?php } ?>
                <button value="3" data-user-id="<?php echo $user_id ?>" data-group-id="<?php echo $group_id ?>" class="btn"><i class="fa fa-ban"></i> 使用者</button>
                <button value="4" data-user-id="<?php echo $user_id ?>" data-group-id="<?php echo $group_id ?>" class="btn"><i class="fa fa-ban"></i> 停權</button>
              </td>
              <?php } ?>
            </tr>
          <?php }
            mysqli_free_result($result);
          ?>
          </tbody>
        </table>
      </div>
    <?php } ?>
      </div>
      <section>
  </main>
</body>
  <script>
    const $btn = $('.btn');

    $btn.on('click', function(e) {
      let url = 'admin_handle_user_group.php';
      let user_id = $(this).data('user-id');
      let user_group_id = $(this).val();

      $.ajax({
        method: 'GET',
        url: url,
        cache: false,
        data: {
          user_id: user_id,
          user_group_id: user_group_id
        }
      })
      .done(function(responsive, checkUserGroup) {
        console.log(responsive);
        location.reload();
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        console.log('error')
      })
    });

    function checkUserGroup() {
      $btn.each(function(i, element) {
        const btn_value = $(element).val();
        const user_group_id = $(element).data('group-id');

        if(btn_value == user_group_id) {
          $(element).find('i').removeClass('fa-ban').addClass('fa-check');
        }
      });
    }

    checkUserGroup();
  </script>
</html>