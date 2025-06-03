<?php
session_start();

// Optional: redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../forms/account_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
  <?php include '../../components/header.php'; ?>
  <?php include '../../components/sidebar.php'; ?>

  <main class="p-6 ml-64">
    <h1 class="text-2xl font-semibold mb-4">Your Profile</h1>

    <div class="space-y-4">
      <a href="change_password.php" class="block w-full md:w-1/2 bg-blue-100 text-blue-700 p-4 rounded hover:bg-blue-200">
        Change Password
      </a>
      <a href="../../logout.php" class="block w-full md:w-1/2 bg-yellow-100 text-yellow-800 p-4 rounded hover:bg-yellow-200">
        Logout
      </a>
      <a href="delete_account.php" class="block w-full md:w-1/2 bg-red-100 text-red-700 p-4 rounded hover:bg-red-200">
        Delete Account
      </a>
    </div>
  </main>
</body>
</html>
