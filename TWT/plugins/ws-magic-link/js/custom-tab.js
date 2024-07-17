document.addEventListener('DOMContentLoaded', function() {
    // Function to show the tab based on the hash
    function showTabFromHash() {
        // Get the current hash
        var hash = window.location.hash;

        // Find all tabs
        var tabs = document.querySelectorAll('.tab1, .tab2');

        // Hide all tabs
        tabs.forEach(function(tab) {
            tab.style.display = 'none';
        });

        // Show the tab that matches the hash
        if (hash) {
            var activeTab = document.querySelector(hash);
            if (activeTab) {
                activeTab.style.display = 'block';
            }
        } else {
            // Default to showing the first tab if no hash
            if (tabs[0]) {
                tabs[0].style.display = 'block';
            }
        }
    }

    // Show the correct tab on page load based on the hash
    showTabFromHash();

    // Show the correct tab when the hash changes
    window.addEventListener('hashchange', showTabFromHash);

    // Add click event listeners to tab links (optional)
    var tabLinks = document.querySelectorAll('[data-tab]');
    tabLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Get the target tab ID from the link
            var targetTab = this.getAttribute('href');

            // Hide all tabs
            var tabs = document.querySelectorAll('.tab1, .tab2');
            tabs.forEach(function(tab) {
                tab.style.display = 'none';
            });

            // Show the target tab
            var targetTabElement = document.querySelector(targetTab);
            if (targetTabElement) {
                targetTabElement.style.display = 'block';
            }

            // Update the URL hash
            history.pushState(null, null, targetTab);
        });
    });
});
