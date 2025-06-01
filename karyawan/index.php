<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Landing Page - Daftar Sekarang</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Fredoka', sans-serif;
      background: linear-gradient(135deg, #0f172a, #1e293b);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 2rem;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      background-color: #0f172a;
      border-radius: 20px;
      padding: 2rem 3rem;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
    }

    .text-section {
      flex: 1;
      max-width: 50%;
    }

    .text-section h1 {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      line-height: 1.6;
    }

    .btn-daftar {
      display: inline-block;
      margin-top: 2rem;
      padding: 1rem 2rem;
      font-size: 1.1rem;
      background: linear-gradient(45deg, #ec4899, #8b5cf6);
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.3s ease;
      text-decoration: none;
      font-weight: bold;
    }

    .btn-daftar:hover {
      transform: scale(1.05);
    }

    .image-section {
      flex: 1;
      max-width: 45%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .image-section img {
      max-width: 100%;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column-reverse;
        text-align: center;
      }
      .text-section, .image-section {
        max-width: 100%;
      }
      .text-section h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="text-section">
      <h1>
        Anda Nganggur?<br>
        Ijazah Anda Ga Berguna?<br>
        Anda Datang Di Website yang tepat!!<br>
        <strong>Daftar Sekaranggggg!!!!</strong>
      </h1>
      <a href="home.php" class="btn-daftar">Daftar Sekarang</a>
    </div>
    <div class="image-section">
      <img src="assets/img/promo.png" alt="Promo Gambar">
    </div>
  </div>
</body>
</html>
