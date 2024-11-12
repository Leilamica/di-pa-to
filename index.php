<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In / Sign Up</title>
    <style>
        body {
           font-family: Arial, sans-serif;
           background: url('https://www.pup.edu.ph/about/images/pylon2022.jpg') no-repeat center center fixed;
           background-size: cover;  /* Ensures the image covers the entire screen */
           margin: 0;
           height: 100vh;
           display: flex;
           justify-content: center; /* Center horizontally */
           align-items: center;     /* Center vertically */
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Maximum width of the form */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color:  #4CAF50;
        }

        .toggle-btn {
            text-align: center;
            margin-top: 10px;
        }

        .toggle-btn a {
            color:  #0000FF;
            text-decoration: none;
        }

        .toggle-btn a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container" id="form-container">
        <!-- Sign In Form -->
        <form id="signin-form" action="signin.php" method="POST">
            <h2>Sign In</h2>
            <input type="email" class="input-field" name="email" placeholder="Email" required>
            <input type="password" class="input-field" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Sign In</button>
            <div class="toggle-btn">
                <p>Don't have an account? <a href="#" onclick="toggleForms()">Sign Up</a></p>
            </div>
        </form>

        <!-- Sign Up Form -->
        <form id="signup-form" style="display: none;" action="signup.php" method="POST">
            <h2>Sign Up</h2>
            <input type="text" class="input-field" name="full_name" placeholder="Full Name" required>
            <input type="email" class="input-field" name="email" placeholder="Email" required>
            <input type="password" class="input-field" name="password" placeholder="Password" required>
            <input type="password" class="input-field" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" class="btn">Sign Up</button>
            <div class="toggle-btn">
                <p>Already have an account? <a href="#" onclick="toggleForms()">Sign In</a></p>
            </div>
        </form>
    </div>
    
    <script>
        function toggleForms() {
            const signinForm = document.getElementById("signin-form");
            const signupForm = document.getElementById("signup-form");
            
            if (signinForm.style.display === "none") {
                signinForm.style.display = "block";
                signupForm.style.display = "none";
            } else {
                signinForm.style.display = "none";
                signupForm.style.display = "block";
            }
        }
    </script>

</body>
</html>
