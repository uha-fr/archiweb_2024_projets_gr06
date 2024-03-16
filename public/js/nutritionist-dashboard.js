document.addEventListener('DOMContentLoaded', function () {
    var modeSwitch = document.querySelector('.mode-switch');

    // Check if dark mode is enabled in localStorage and apply it on page load
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.documentElement.classList.add('dark');
        modeSwitch.classList.add('active');
    }

    // Add event listener to mode switch
    modeSwitch.addEventListener('click', function () {
        // Toggle dark mode class on documentElement
        document.documentElement.classList.toggle('dark');

        // Toggle active class on modeSwitch
        modeSwitch.classList.toggle('active');

        // Update dark mode state in localStorage
        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    });


    var listView = document.querySelector('.list-view');
    var gridView = document.querySelector('.grid-view');
    var projectsList = document.querySelector('.project-boxes');

    // listView.addEventListener('click', function () {
    //   gridView.classList.remove('active');
    //   listView.classList.add('active');
    //   projectsList.classList.remove('jsGridView');
    //   projectsList.classList.add('jsListView');
    // });

    // gridView.addEventListener('click', function () {
    //   gridView.classList.add('active');
    //   listView.classList.remove('active');
    //   projectsList.classList.remove('jsListView');
    //   projectsList.classList.add('jsGridView');
    // });

    document.querySelector('.messages-btn').addEventListener('click', function () {
        document.querySelector('.messages-section').classList.add('show');
    });

    document.querySelector('.messages-close').addEventListener('click', function () {
        document.querySelector('.messages-section').classList.remove('show');
    });
});