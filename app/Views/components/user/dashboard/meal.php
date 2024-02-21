<div class="flex flex-column justify-content-start bg-bg p-4 rounded" style="width: fit-content; min-width: 250px">
    <img style="width: 200px; height: 200px; object-fit: cover; border-radius: 100%;" src=<?= $meal->image ?? "https://www.allrecipes.com/thmb/5SdUVhHTMs-rta5sOblJESXThEE=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/11691-tomato-and-garlic-pasta-ddmfs-3x4-1-bf607984a23541f4ad936b33b22c9074.jpg" ?> />
    <div class="mt-4">
        <p style="margin: 0;">
            <?= $meal->calories ?? "400" ?> Cal
        </p>
        <p class="fw-bold" style="font-size: 20px; padding-top: 0px">
            <?= $meal->name ?? "Spaghetti Presto Pasta" ?>
        </p>
    </div>
</div>