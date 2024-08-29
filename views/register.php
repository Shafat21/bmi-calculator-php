<!-- views/register.php -->
<?php
session_start();
require_once '../includes/db.php';
require '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO AppUsers (Username, Password) VALUES (?, ?)");
    if ($stmt->execute([$username, $hashedPassword])) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Username might already be taken.";
    }
}

if (isset($_SESSION['error'])) {
    echo "<script>Swal.fire('Error', '" . $_SESSION['error'] . "', 'error');</script>";
    unset($_SESSION['error']);
}

?>

<div class="min-h-screen flex items-center justify-center bg-gray-900 text-white">
    <div class="max-w-md w-full bg-gray-800 p-8 rounded-lg shadow-lg">
        <h2 class="text-center text-3xl font-extrabold text-gray-100 mb-6">
            Create your account
        </h2>
        <form class="space-y-6" action="register.php" method="POST">
            <div class="rounded-md shadow-sm">
                <div class="mb-4">
                    <label for="username" class="sr-only">Username</label>
                    <input id="username" name="username" type="text" autocomplete="username" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Username">
                </div>
                <div class="mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Password">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>
        </form>
        <div class="text-center mt-6">
            <p class="text-sm text-gray-400">Already have an account?</p>
            <a href="login.php" class="mt-2 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full shadow">
                Login
            </a>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>
