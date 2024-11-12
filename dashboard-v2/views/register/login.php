<?php ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

require_once '../../model/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = new PDO("mysql:host=localhost;dbname=e_commerce", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize the flags to false
    $invalidEmail = false;
    $invalidPassword = false;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND is_active = 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user was found
    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Check user role
            if ($user['role'] === 'admin' || $user['role'] === 'super_admin') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                header("Location: /");
                exit;
            } else {
                $error = "Access denied. You do not have the required role.";
            }
        } else {
            $invalidPassword = true; // Password is incorrect
        }
    } else {
        $invalidEmail = true; // Email does not exist
    }

    // Set appropriate error message
    if ($invalidEmail && $invalidPassword) {
        $error = "Invalid email and password.";
    } elseif ($invalidEmail) {
        $error = "Invalid email.";
    } elseif ($invalidPassword) {
        $error = "Invalid password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4299e1; /* Blue 500 */
            --secondary-color: #2c5282; /* Blue 700 */
            --bg-color: #f7fafc; /* Gray 50 */
            --text-color: #2d3748; /* Gray 800 */
            --border-color: #e2e8f0; /* Gray 200 */
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .form-input {
            padding-left: 2.5rem;
            border-color: var(--border-color);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
            outline: none;
        }

        .submit-button {
            background-color: var(--primary-color);
            color: #fff;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background-color: var(--secondary-color);
        }

        .security-icons {
            color: #a0aec0; /* Gray 400 */
        }
    </style>
</head>

<body class="min-h-screen animate-gradient flex items-center justify-center p-6">
    <div class="glass-effect w-full max-w-md rounded-2xl shadow-2xl p-8 space-y-8">
        <!-- Logo Section -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 mb-6">
                <i class="fas fa-shield-alt text-3xl text-blue-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Admin Login</h2>
            <p class="mt-2 text-sm text-gray-600">Please sign in to access your dashboard</p>
        </div>

        <!-- Error Message -->
        <?php if (isset($error)) : ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="login.php" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email Address
                </label>
                <div class="mt-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" required
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="admin@example.com">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <div class="mt-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember-me" name="remember-me"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        Forgot password?
                    </a>
                </div>
            </div> -->

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent 
                               text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                               transition-colors duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    Sign in to Dashboard
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-600">
            <p>Protected by enhanced security</p>
            <div class="flex justify-center space-x-4 mt-4">
                <i class="fas fa-shield-alt text-gray-400"></i>
                <i class="fas fa-lock text-gray-400"></i>
                <i class="fas fa-fingerprint text-gray-400"></i>
            </div>
        </div>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>