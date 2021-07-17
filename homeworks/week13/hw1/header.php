<?php
  $REQUEST_URI = $_SERVER['REQUEST_URI'];
  $isAdminPage = (strpos($REQUEST_URI, 'admin.php') !== false)
?>
<nav class="navbar">
  <div class="wrapper navbar__wrapper">
    <div class="navbar__site-name">
      <a href='index.php'>Wei's Blog</a>
    </div>
    <ul class="navbar__list">
      <div>
        <li><a href="article_list.php">文章列表</a></li>
        <li><a href="category_list.php">分類專區</a></li>
        <li><a href="about_me.php?id=1">關於我</a></li>
      </div>
      <div>
      <?php if(!$username) { ?>  
        <li><a href="login.php">登入</a></li>
      <?php } else { ?>
        <?php if($isAdminPage) { ?>
            <li><a href="category.php">分類管理</a></li>
            <li><a href="create_article.php">新增文章</a></li>
            <li><a href="logout.php">登出</a></li>
          <?php } else { ?>
            <li><a href="admin.php">管理後台</a></li>
            <li><a href="logout.php">登出</a></li>
          <?php } ?>
      <?php } ?>
      </div>
    </ul>
  </div>
</nav>