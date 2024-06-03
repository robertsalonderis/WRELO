<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Planning System Home</title>
    <style>
        body, h1, p {
            margin: 0;
            padding: 0;
        }

        .home-header-bc{
            background-color: #5e6c84;
            height: 60px;
        }

        .home-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2px 10px; /* Adjust header padding */
            color: #fff;
            height: 60px; /* Adjust header height */
            max-width: 1300px;
            background-color: #5e6c84;
            margin: auto;
        }

        .right-hdr{
            margin: left;
            font-weight: 600;
        }

        .footer {
            background-color: #026aa7;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
        /*.Content*/

        .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2em;
}

.section {
    margin-bottom: 2em;
    padding: 2em;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.section h2 {
    color: #0079bf;
    margin-bottom: 1em;
}

.blocks {
    display: flex;
    flex-wrap: wrap;
    gap: 1em;
}

.functionality-block {
    flex: 1 1 calc(33.333% - 1em);
    padding: 20px;
    margin: 20px;
    background-color: #f4f5f7;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.functionality-block h1 {
    color: #5e6c84;
}

.functionality-block p {
    color: #172b4d;
}

.description-section {
    padding: 2em;
    background-color: #e1f5fe;
    border-radius: 8px;
}

.integration-section {
    padding: 2em;
    background-color: #ffffff;
    border-radius: 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 1em;
}

.integration-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.integration-description {
    flex: 1 1 100%;
    padding: 1em;
}

.integration-image {
    flex: 1 1 100%;
    padding: 1em;
}

.integration-image img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

hr{
    margin: 3rem;
}
    </style>
</head>
<body>

</style>
<title>WRELO</title>
</head>
<body>
<header class="home-header-bc">
    <div class="home-header">
  <div class="left-header">
    <div class="logo">
      <a href="index.php">
        <img
          src="images/Wrelo-removebg-preview.png"
          alt="Trello Logo"
        />
      </a>
      <h3>|</h3>
      <h4>Wrello</h4> <h5>- An Planning System App With WhatsApp Chat Integration</h5>
    </div>
  </div>

    <div class="right-hdr">
        <a href="Login/login.php" class="login-button">Log In</a>
    </div>
</div>

</header>

<div class="container">
    <section class="functionality-section">
        <h2>Key Features</h2>
        <div class="blocks">
            <div class="functionality-block">
                <h1>Boards</h1>
                <p>Organize projects, tasks, and ideas in a customizable layout. Boards represent high-level containers for your workflows.</p>
            </div>
            <div class="functionality-block">
                <h1>Cards</h1>
                <p>Cards are individual tasks or items that can be moved across lists and boards. They can contain due dates, attachments, and conversations.</p>
            </div>
            <div class="functionality-block">
                <h1>Lists</h1>
                <p>Lists help in categorizing the cards. You can create lists for various stages of a project or different types of activities.</p>
            </div>
            <div class="functionality-block">
                <h1>File Sharing</h1>
                <p>Share files effortlessly among team members directly through the app. Supports documents, images, and other file types.</p>
            </div>
            <div class="functionality-block">
                <h1>Communication via WhatsApp</h1>
                <p>Integrate communication with WhatsApp to send messages, alerts, and notifications directly from the system to your team's devices.</p>
            </div>
        </div>
    </section>

    <hr>

    <section class="description-section">
        <h2>How It Works</h2>
        <p>Our planning web app simplifies project management by allowing you to organize tasks, set deadlines, and collaborate with your team. Using boards, lists, and cards, you can visualize your projects and track progress. Integrated file sharing and WhatsApp communication ensure seamless interaction and productivity.</p>
    </section>

    <hr>

    <section class="integration-section">
        <h2>WhatsApp Integration</h2>
        <div class="integration-container">
            <div class="integration-description">
                <p>Combine the power of planning with the convenience of WhatsApp. Manage your projects and chat with your team all in one place. The right side of the screen features your planning board while the left side keeps you connected through WhatsApp chat. Stay organized and communicate efficiently.</p>
            </div>
            <div class="integration-image">
                <img src="images/WhatsApp_icon.png" alt="WhatsApp">
            </div>
        </div>
    </section>
</div>


    <div class="footer">
        <p>&copy; 2024 WRELO</p>
    </div>

</body>
</html>





