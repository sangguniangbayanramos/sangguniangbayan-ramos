<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Suggestions & Questions</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #cfd9df, #e2ebf0);
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
    min-height: 100vh;
  }

  .container {
    background: #fff;
    padding: 30px 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    width: 650px;
    animation: fadeIn 0.4s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .header {
    background: linear-gradient(90deg, #0b5ed7, #2a9df4);
    color: white;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }

  .header h2 {
    margin: 0;
    font-size: 24px;
  }

  .filter-buttons {
    text-align: center;
    margin-bottom: 20px;
  }

  .filter-buttons button {
    background: #0b5ed7;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 25px;
    margin: 0 5px;
    cursor: pointer;
    transition: 0.2s;
    font-weight: 500;
  }

  .filter-buttons button:hover {
    background: #004aad;
    transform: scale(1.05);
  }

  .entry {
    background: #f9fbfd;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 15px;
    border-left: 6px solid #0b5ed7;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    transition: 0.2s;
  }

  .entry:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
  }

  .entry-type {
    font-weight: bold;
    color: #0b5ed7;
    font-size: 14px;
    margin-bottom: 4px;
  }

  .entry strong {
    color: #333;
  }

  .entry p {
    margin: 4px 0;
    color: #444;
  }

  .entry-date {
    font-size: 12px;
    color: #777;
    margin-top: 6px;
  }

  .actions {
    text-align: right;
    margin-top: 8px;
  }

  .actions button {
    background: #dc3545;
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    transition: 0.2s;
  }

  .actions button:hover {
    background: #b02a37;
  }

  .no-data {
    text-align: center;
    color: #999;
    font-style: italic;
    margin-top: 30px;
  }

  .no-data img {
    width: 150px;
    opacity: 0.7;
    margin-bottom: 10px;
  }
</style>
</head>
<body>

<div class="container">
  <div class="header">
    <h2>📋 Admin Dashboard — Suggestions & Questions</h2>
  </div>

  <div class="filter-buttons">
    <button onclick="filterEntries('Suggestion')">Suggestions</button>
    <button onclick="filterEntries('Question')">Questions</button>
  </div>

  <div id="entriesContainer"></div>
  
  <button onclick="window.location.href='Dashboard.php'" class="filter-buttons">Go back</button>


<script>
  const container = document.getElementById('entriesContainer');
  let entries = JSON.parse(localStorage.getItem('entries')) || [];

  function renderEntries(filter = 'all') {
    container.innerHTML = '';

    const filtered = filter === 'all' ? entries : entries.filter(e => e.type === filter);

    if (filtered.length === 0) {
      container.innerHTML = `
        <div class="no-data">
          <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Data">
          <p>No ${filter === 'all' ? 'suggestions or questions' : filter.toLowerCase() + 's'} yet.</p>
        </div>`;
      return;
    }

    filtered.forEach((entry, index) => {
      const div = document.createElement('div');
      div.classList.add('entry');
      div.innerHTML = `
        <div class="entry-type">🗂 ${entry.type}</div>
        <p><strong>${entry.name}</strong>: ${entry.message}</p>
        <div class="entry-date">📅 ${entry.date}</div>
        <div class="actions">
          <button onclick="deleteEntry(${index})">🗑 Delete</button>
        </div>
      `;
      container.appendChild(div);
    });
  }

  function filterEntries(type) {
    renderEntries(type);
  }

  function deleteEntry(index) {
    if (confirm('Are you sure you want to delete this entry?')) {
      entries.splice(index, 1);
      localStorage.setItem('entries', JSON.stringify(entries));
      renderEntries();
    }
  }

  renderEntries();
</script>

</body>
</html>
