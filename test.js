function uploadImage() {
    var formData = new FormData();
    var fileInput = document.getElementById('imageInput');
    
    // Check if a file is selected
    if (fileInput.files.length > 0) {
      formData.append('image', fileInput.files[0]);
  
      // Make a fetch request
      fetch('test.php', {  //remplir l'url
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Handle the server response
        document.getElementById('result').innerHTML = data.message;
      })
      .catch(error => {
        console.error('Error uploading image:', error);
      });
    } else {
      alert('Please select an image to upload.');
    }
  }