<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: pages/tables/riwayat.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard | BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('photo/bg.png');
      background-size: cover;
      background-position: center;
    }
  </style>
</head>
<body class="min-h-screen bg-black/50 text-black-100 flex items-center justify-center px-4">

  <div class="bg-white max-w-4xl w-full rounded-2xl shadow-2xl backdrop-blur-md p-8 md:p-12 flex flex-col md:flex-row items-center gap-10">
    
    <div class="flex-1 text-center md:text-left">
      <h1 class="text-5xl font-extrabold mb-4">
        Welcome to 
        <span class="text-yellow-400">Budget</span><span class="text-pink-400">In</span>
      </h1>
      <p class="text-black text-lg mb-6">
        Track your spending, plan better, and stay on budget — all in one place.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
        <a href="pages/tables/riwayat.php" class="px-6 py-3 bg-yellow-400 text-black rounded-xl hover:bg-yellow-500 transition font-semibold">View History</a>
        <a href="pages/forms/account_login.php" class="px-6 py-3 bg-pink-500 text-white rounded-xl hover:bg-pink-600 transition font-semibold border border-pink-600">Login</a>
        <a href="pages/forms/account_sign_up.php" class="px-6 py-3 bg-white/70 text-pink-600 rounded-xl hover:bg-white transition font-semibold border border-pink-600">Sign Up</a>
      </div>
    </div>

    <div class="flex-1">
      <img src="photo/wlc.png" alt="Finance Illustration" class="w-96 mx-auto" />
    </div>
  </div>

</body>
</html>
