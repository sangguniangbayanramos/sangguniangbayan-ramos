<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Municipality of Ramos - Official Landing Page</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      margin: 0;
      background: #f4f6f9;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background: #004aad;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    main {
      flex: 1;
      padding: 40px;
      text-align: center;
      padding-bottom: 80px; /* para hindi matakpan ng fixed footer */
    }

    h2 {
      color: #004aad;
      margin-bottom: 20px;
      font-size: 26px;
    }

    .photo-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .photo-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: 0.3s;
    }

    .photo-card:hover {
      transform: scale(1.03);
    }

    .photo-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-bottom: 1px solid #eeeeee;
    }

    .photo-card p {
      padding: 10px;
      font-size: 15px;
      font-weight: 500;
      color: #444;
    }

    footer {
      background: #004aad;
      color: white;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: 100;
    }

    .no-photo {
      font-size: 18px;
      color: #777;
      margin-top: 30px;
    } 

   
  </style>
</head>
<body>
  <header>Municipality of Ramos - Official Website</header>

  <main>
    <h2>📸 Featured Photos</h2> 
    <div id="photoGallery" class="photo-grid"></div>
    <p id="noPhotoMessage" class="no-photo" style="display: none;">
      No photos selected yet. Please visit the admin page to upload and select photos.
    </p>
  </main>

  <footer>
    © 2025 Municipality of Ramos | All Rights Reserved
  </footer>

  <script>
    function loadSelectedPhotos() {
      const photos = JSON.parse(localStorage.getItem("photos") || "[]");
      const selectedPhotos = photos.filter(photo => photo.selected);
      const gallery = document.getElementById("photoGallery");
      const noPhotoMsg = document.getElementById("noPhotoMessage");

      gallery.innerHTML = "";

      if (selectedPhotos.length === 0) {
        noPhotoMsg.style.display = "block";
        return;
      } else {
        noPhotoMsg.style.display = "none";
      }

      selectedPhotos.forEach(photo => {
        const div = document.createElement("div");
        div.classList.add("photo-card");

        div.innerHTML = `
          <img src="${photo.src}" alt="Municipality Photo">
          <p>${photo.caption || "(No caption)"}</p>
        `;
        gallery.appendChild(div);
      });
    }

    loadSelectedPhotos();
  </script>
</body>
</html>
