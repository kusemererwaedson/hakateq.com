

document.addEventListener("DOMContentLoaded", function() {
    const fileInput = document.getElementById("fileInput");
    const profileImage = document.getElementById("profileImage");
    const chooseImageButton = document.getElementById("chooseImage");
    const uploadImageButton = document.getElementById("uploadImage");
    const profileForm = document.getElementById("profileForm");

    let selectedFile = null;

    chooseImageButton.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        selectedFile = fileInput.files[0];
        if (selectedFile) {
            profileImage.src = URL.createObjectURL(selectedFile);
        }
    });

    uploadImageButton.addEventListener("click", () => {
        if (!selectedFile) {
            alert("Please choose an image before uploading.");
            return;
        }

        if (confirm("Are you sure you want to update your profile image?")) {
            const formData = new FormData();
            formData.append("profile_image", selectedFile);

            fetch("upload.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Profile image uploaded successfully!");
                    // Update the image source to the new URL in "assets/images"
                    profileImage.src = "assets/images/" + data.fileName;

                    // Now, you can send a request to update the database with the new image
                    updateDatabaseWithNewImage(data.fileName);
                } else {
                    alert("Upload failed: " + data.message);
                }
            })
            .catch(error => {
                alert("Upload failed: " + error.message);
            });
        }
    });

    // Function to update the database with the new image (replace with your actual database update code)
    function updateDatabaseWithNewImage(fileName) {
        // You can use AJAX or another method to send the request to your server
        // Example using fetch:
        fetch("update_database.php", {
            method: "POST",
            body: JSON.stringify({ fileName: fileName }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Database updated successfully!");
            } else {
                console.error("Database update failed: " + data.message);
            }
        })
        .catch(error => {
            console.error("Database update failed: " + error.message);
        });
    }
});


