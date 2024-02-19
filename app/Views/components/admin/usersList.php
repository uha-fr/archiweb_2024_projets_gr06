

<main>
    <div class="header">
      <div class="left">
        <h1>Users list</h1>
        
      </div>
     
    </div>

    <!-- End of Insights -->

    <div class="bottom-data">
      <!-- Orders -->
      <div class="orders">
        
        <div id="showUser">

        
        </div>

      </div>
      <!-- End of Orders -->

      
      <!-- End of Reminders -->
    </div>
  </main>
    <!-- AJAX response will be inserted here -->

  <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>


<script type="text/javascript">
   console.log("Document ready");
$(document).ready(function() {
    console.log("Making AJAX call");
    performAjaxRequest("GET", "getAllUsers", "", "", "");
});

   
  
</script>