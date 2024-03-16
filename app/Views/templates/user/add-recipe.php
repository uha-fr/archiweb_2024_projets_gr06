  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/colors.css" />
    <link rel="stylesheet" href="<?= BASE_APP_DIR ?>/public/css/globals.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>

  <body>

    <!-- BODY -->
    <div class="bg-bg">
      <!-- ADD RECIPE Form-->
      <div class="w-full items-center flex-column flex min-h-screen pt-0">
        <h1 class="text-5xl font-bold">Add Recipe</h1>
        <form enctype="multipart/form-data" class="bg-gray w-[500px] rounded min-h-[400px] mt-14 p-8" id="form-data" action="" method="post">
          <div class="flex flex-column">
            <label for="recipe name" class="font-bold text-white">Recipe name</label>
            <input type="text" name="name" id="name" placeholder="Ex: Burger" class="py-3 px-4 rounded mt-2" required />
          </div>
          <div class="flex flex-column mt-4">
            <label class="font-bold text-white">calories number</label>
            <input type="text" name="calories" id="calories" placeholder="Ex: 300" class="py-3 px-4 rounded mt-2" required onkeypress="return event.charCode >= 48 && event.charCode <= 57 || (event.charCode === 46 && this.value.indexOf('.') === -1)" oninput="this.value = this.value.replace(/^(-\d*\.?\d*)$/g, '')" /> <input type="file" id="image_url" name="img_url" placeholder="url temp" class="py-3 px-4 rounded mt-2" required />
          </div>
          <div class="flex flex-column mt-4">
            <input type="submit" class="py-3 px-4 bg-[#d6ff92] rounded w-full" name="addRecipe" id="addRecipe" value="Add recipe">
          </div>
        </form>
      </div>
    </div>

    <script src="<?= BASE_APP_DIR ?>/public/js/ajax.js"></script>

    <script>
      $("#addRecipe").click(function(e) {
        console.log("dans ADD RECIPE");
        if ($("#form-data")[0].checkValidity()) {
          e.preventDefault();
          performAjaxRequestWithImg(
            "POST",
            "addRecipe",
            "",
            "Recipe added successfully!",
            ""
          );

        }
      });
    </script>
  </body>

  </html>
