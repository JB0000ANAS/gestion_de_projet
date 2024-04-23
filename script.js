
document.addEventListener('DOMContentLoaded', function() {
    // Modal controls
    const modal = document.getElementById('myModal');
    const loginBtn = document.getElementById('loginBtn');
    const signUpBtn = document.getElementById('signupBtn');
    const closeModalBtn = document.querySelector('.close');

    // Opening and closing the modal
    function toggleModal() {
        modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
    }

    closeModalBtn.onclick = toggleModal;

    // Function to open specific tab in the modal
    function openTab(event, tabId) {
        const tabContents = document.getElementsByClassName("tabcontent");
        for (let i = 0; i < tabContents.length; i++) {
            tabContents[i].style.display = "none";
        }

        const tabLinks = document.getElementsByClassName("tablink");
        for (let i = 0; i < tabLinks.length; i++) {
            tabLinks[i].className = tabLinks[i].className.replace(" active", "");
        }

        document.getElementById(tabId).style.display = "block";
        event.currentTarget.className += " active";
    }

    // Attach openTab to tab buttons
    document.querySelectorAll('.tablink').forEach(button => {
        button.onclick = (event) => openTab(event, event.target.getAttribute('data-target'));
    });

    // AJAX for form submission
    function submitForm(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const url = form.getAttribute('action');

        // AJAX request
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Using text() as the PHP script might not return JSON
        .then(data => {
            // You can modify this part based on how your PHP script responds
            alert('Success!');
            toggleModal();
            // You might want to check data for a specific message or status
            window.location.reload(); // Refresh the page to update the UI
        })
        .catch(error => console.error('Error:', error));
    }

    // Attach submitForm to forms
    document.querySelectorAll('#Login form, #SignUp form').forEach(form => {
        form.onsubmit = submitForm;
    });

    // Define openModal function within the same scope
    function openModal(tabName) {
        modal.style.display = "block";
        document.getElementById(tabName).style.display = "block";
        var tablinks = document.getElementsByClassName("tablink");
        for (var i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
            if (tablinks[i].getAttribute('data-target') === tabName) {
                tablinks[i].className += " active";
            }
        }
    }

    // Attach event listeners to buttons
    if (loginBtn) {
        loginBtn.addEventListener('click', () => openModal('Login'));
    }

    if (signUpBtn) {
        signUpBtn.addEventListener('click', () => openModal('SignUp'));
    }

    // Close button functionality
    closeModalBtn.onclick = function() {
        modal.style.display = 'none';
    };

    // Clicking outside the modal closes it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
});

document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
  
    function showSlide(index) {
      // Hide all slides
      slides.forEach(slide => {
        slide.style.display = 'none';
      });
      
      // Show the targeted slide
      slides[index].style.display = 'block';
    }
  
    // Click event for the Previous button
    document.getElementById('prevButton').addEventListener('click', function() {
      currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
      showSlide(currentSlide);
    });
  
    // Click event for the Next button
    document.getElementById('nextButton').addEventListener('click', function() {
      currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
      showSlide(currentSlide);
    });
  
    // Initialize the slider by showing the first slide
    showSlide(currentSlide);
  });
  

  
  












