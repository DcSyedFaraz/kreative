<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Pending</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .pending-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 550px;
            padding: 3rem;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-container {
            margin-bottom: 2rem;
        }

        .pending-icon {
            background-color: #f0f9ff;
            color: #3498db;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        h2 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .message {
            color: #7f8c8d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .status-bar {
            margin: 2rem 0;
            position: relative;
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }

        .status-progress {
            position: absolute;
            height: 100%;
            background: linear-gradient(90deg, #3498db, #2980b9);
            width: 30%;
            border-radius: 5px;
            animation: progress 2s infinite alternate;
        }

        @keyframes progress {
            from {
                width: 25%;
            }

            to {
                width: 35%;
            }
        }

        .action-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }

        .action-button:hover {
            background-color: #2980b9;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .contact-info {
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #95a5a6;
        }

        .contact-info a {
            color: #3498db;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .pending-container {
                padding: 2rem;
                width: 95%;
            }

            h2 {
                font-size: 1.8rem;
            }

            .message {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="pending-container">
        <div class="icon-container">
            <div class="pending-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>

        <h2>Registration Pending</h2>

        <p class="message">
            Your registration has been received and is currently pending approval.
            Our admin team will review your request shortly. You will receive an
            email notification once your account has been activated.
        </p>

        <div class="status-bar">
            <div class="status-progress"></div>
        </div>

        <p class="message">
            Thank you for your patience. This process typically takes 24-48 hours.
        </p>

        <a href="/" class="action-button">Return to Homepage</a>

        <div class="contact-info">
            <p>Have questions? <a href="mailto:support@example.com">Contact our support team</a></p>
        </div>
    </div>
</body>

</html>
