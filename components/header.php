<header class="bg-white shadow-md p-4 flex items-center justify-between px-6 relative z-40">
  <div class="flex items-center gap-4">
    <button onclick="toggleSidebar()" class="text-2xl text-gray-700 hover:text-yellow-500">
      &#9776;
    </button>
    <h1 class="text-xl font-extrabold mb-4">
      <span class="text-yellow-400">Budget</span><span class="text-pink-400">In</span>
    </h1>
  </div>
  <nav class="flex items-center gap-6">
    <!-- <a href="/BUDGETIN/index.php" class="text-gray-600 hover:text-yellow-600 transition">Dashboard</a> -->
    <a href="profile.php" class="text-gray-600 hover:text-yellow-600 transition">Profile</a>
    <a href="../../logout.php" class="text-red-500 hover:text-red-600 font-medium transition">Logout</a>
  </nav>
</header>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('hidden');
  }
</script>