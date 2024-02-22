
 <?php
 // Define an associative array with background colors based on the goal
$backgroundColors = [
    'gain-weight-normal' => '#c8f7dc',
    'lose-weight-fast' => '#ffd3e2',
    'lose-weight-normal' => '#e9e7fd'
];

$spanColors = [
  'gain-weight-normal' => '#34c471',
  'lose-weight-fast' => '#df3670',
  'lose-weight-normal' => '#4f3ff0'
];
 ?>  
 
   
   <?php foreach ($data as $row) : ?>
        <?php


// Get the background color based on the goal
$goal = htmlspecialchars($row->goal); // Assuming $row->goal contains the goal information
$backgroundColor = isset($backgroundColors[$goal]) ? $backgroundColors[$goal] : '';

$spanColor = isset($spanColors[$goal]) ? $spanColors[$goal] : '';

// If no specific color is found, you can set a default color
if (!$backgroundColor) {
    $backgroundColor = '#ffffff'; // Default to white
}
?>


<div class="project-box-wrapper">
            <div class="project-box" style="background-color: <?= $backgroundColor ?>;">
              <div class="project-box-header">
                <span>December 10, 2020</span>
                <div class="more-wrapper">
                  <button class="project-btn-more">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                      <circle cx="12" cy="12" r="1" />
                      <circle cx="12" cy="5" r="1" />
                      <circle cx="12" cy="19" r="1" /></svg>
                  </button>
            </div>
           </div>
            <div class="project-box-content-header">
              <p class="box-content-header"><?= htmlspecialchars($row->fullname) ?> </p>
              <p class="box-content-subheader"><?= htmlspecialchars($row->goal) ?> </p>
            </div>
          <div class="box-progress-wrapper">
            <p class="box-progress-header">Progress</p>
            <div class="box-progress-bar">
              <span class="box-progress" style="width: 60%; background-color: <?= $spanColor ?>"></span>
            </div>
            <p class="box-progress-percentage">60%</p>
          </div>
          <div class="project-box-footer">
            <div class="participants">
              <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2550&q=80" alt="participant">
              <img src="https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MTB8fG1hbnxlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60" alt="participant">
              <button class="add-participant" style="color: <?= $spanColor ?>;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                  <path d="M12 5v14M5 12h14" />
                </svg>
              </button>
            </div>
            <div class="days-left" style="color: <?= $spanColor ?>;">
              2 Days Left
            </div>
          </div>
        </div>
</div> 
        <?php endforeach; ?>
