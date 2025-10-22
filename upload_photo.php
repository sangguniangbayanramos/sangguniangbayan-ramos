<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Upload Photos | Municipality of Ramos</title>
<style>
  body {
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #e3f2fd, #ffffff);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
  }

  .dashboard {
    background: #fff;
    width: 90%;
    max-width: 1000px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    margin-top: 40px;
    padding: 30px;
  }

  h2 {
    text-align: center;
    color: #0b5ed7;
    margin-bottom: 20px;
  }

  .upload-section {
    text-align: center;
    margin-bottom: 25px;
  }

  input[type="file"] {
    margin-top: 10px;
  }

  .photo-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 15px;
  }

  .photo-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    background: #f9f9f9;
    text-align: center;
  }

  .photo-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 6px;
  }

  .photo-card input[type="text"] {
    width: 90%;
    margin-top: 8px;
    padding: 5px;
    font-size: 13px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }

  .photo-card label {
    display: block;
    margin-top: 6px;
    font-size: 14px;
  }

  button {
    background: #0b5ed7;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    cursor: pointer;
    margin-top: 15px;
  }

  button:hover {
    background: #093e91;
  }

  .footer {
    text-align: center;
    color: #777;
    margin-top: 30px;
  }

</style>
</head>
<body>

<div class="dashboard">
  <h2>📤 Upload Photos - Municipality of Ramos</h2>

  <div class="upload-section">
    <input type="file" id="photoUpload" accept="image/*" multiple>
    <br>
    <button onclick="uploadPhotos()">Upload</button>
  </div>

  <div class="photo-list" id="photoList"></div>

  <div class="footer">© 2025 Municipality of Ramos | Admin Upload Panel</div>
</div>

<script>
  function uploadPhotos() {
    const input = document.getElementById('photoUpload');
    const files = input.files;

    if (files.length === 0) {
      alert("Please select at least one photo to upload.");
      return;
    }

    const photos = JSON.parse(localStorage.getItem('photos')) || [];

    Array.from(files).forEach(file => {
      const reader = new FileReader();
      reader.onload = function(e) {
        photos.push({
          src: e.target.result,
          caption: '',
          selected: false
        });
        localStorage.setItem('photos', JSON.stringify(photos));
        displayPhotos();
      };
      reader.readAsDataURL(file);
    });

    input.value = '';
  }

  function displayPhotos() {
    const photoList = document.getElementById('photoList');
    const photos = JSON.parse(localStorage.getItem('photos')) || [];

    photoList.innerHTML = '';

    photos.forEach((photo, index) => {
      const div = document.createElement('div');
      div.classList.add('photo-card');
      div.innerHTML = `
        <img src="${photo.src}">
        <input type="text" placeholder="Enter caption..." value="${photo.caption}" 
          onchange="updateCaption(${index}, this.value)">
        <label>
          <input type="checkbox" ${photo.selected ? 'checked' : ''} 
            onchange="toggleSelect(${index}, this.checked)"> Show on Landing Page
        </label>
        <button onclick="deletePhoto(${index})">🗑 Delete</button>
      `;
      photoList.appendChild(div);
    });
  }

  function updateCaption(index, caption) {
    const photos = JSON.parse(localStorage.getItem('photos')) || [];
    photos[index].caption = caption;
    localStorage.setItem('photos', JSON.stringify(photos));
  }

  function toggleSelect(index, selected) {
    const photos = JSON.parse(localStorage.getItem('photos')) || [];
    photos[index].selected = selected;
    localStorage.setItem('photos', JSON.stringify(photos));
  }

  function deletePhoto(index) {
    const photos = JSON.parse(localStorage.getItem('photos')) || [];
    if (confirm("Are you sure you want to delete this photo?")) {
      photos.splice(index, 1);
      localStorage.setItem('photos', JSON.stringify(photos));
      displayPhotos();
    }
  }

  displayPhotos();
</script>

</body>
</html>
