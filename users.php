<?php 
      include("db_connect.php");
      include("header.php");
      session_start();

      class user {
        public $id;
        public $email;
        public $username;
    
        function __construct($id, $username, $email){
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
        }
    
        function get_id(){
           return $this->id; }
        function get_username(){ 
          return $this->username; }
        function get_email(){
          return $this->email; }

    }
    
    
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $delete = "DELETE FROM clients WHERE id = $id";
        if (mysqli_query($link, $delete)) {
            echo "user deleted successfully!";
        } else {
            echo "Error deleting user: " . mysqli_error($link);
        }
    }
                         ?>

<section id="header3">
    <h1 id="title">Users</h1>
    <p>manager</p>
   </section> 

<section>
   <?php $users = mysqli_query($link, "SELECT * FROM clients"); ?>

<div id="display_users">
    <?php while ($row = mysqli_fetch_assoc($users)) { ?>
        <div class="user">
            <h2><?php echo htmlspecialchars($row['id']); ?></h2>
            <p>username: <?php echo htmlspecialchars($row['username']); ?></p>
           <p>email: <?php echo htmlspecialchars($row['email']); ?></p><BR>
           <button><a href="users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a></button>
  </div>
  <?php } ?>  
  </div>
</section>


<script src="script_admin/script.js"></script>
</body>
</html>