<?php
session_start();

// If user is already logged in, redirect to riwayat page
if (isset($_SESSION['user_id'])) {
  header("Location: pages/tables/riwayat.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="text-center bg-white p-10 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to BudgetIn</h1>

    <div class="space-x-4">
      <a href="pages/forms/account_login.php" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</a>
      <a href="pages/forms/account_sign_up.php" class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Sign Up</a>
    </div>
  </div>

</body>
</html>
