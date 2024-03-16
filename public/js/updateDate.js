// This function will update the element with the ID 'currentTime' with the current date
function updateCurrentDate() {
  const currentDate = new Date();

  // Format the date as "Month, Day, Year"
  const formattedDate = currentDate.toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric'
  });

  // Set the text of the element with id="currentTime" to the formatted date
  document.getElementById('currentTime').textContent = formattedDate;
}


