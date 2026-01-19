<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- <script>
    $(document).ready(function() {

        // Show/hide dropdown menu on hover

        $('.nav-item.dropdown').each(function(index) {

            var dropdownMenu = $(this).find('.dropdown-menu');

            $(this).on('mouseenter', function() {

                dropdownMenu.stop(true, true).delay(200).slideDown(300);

            }).on('mouseleave', function() {

                dropdownMenu.stop(true, true).delay(200).slideUp(300);

            });

        });



        // Navigate to the specified route when clicking on dropdown toggle or items

        $('.nav-item.dropdown .nav-link, .nav-item.dropdown .dropdown-item').on('click', function(event) {

            window.location.href = $(this).attr('href');

        });

    });
</script> -->
<script>
    $(document).ready(function() {
        // Show/hide dropdown menu on hover for desktop
        $('.nav-item.dropdown').each(function(index) {
            var dropdownMenu = $(this).find('.dropdown-menu');
            $(this).on('mouseenter', function() {
                dropdownMenu.stop(true, true).delay(200).slideDown(300);
            }).on('mouseleave', function() {
                dropdownMenu.stop(true, true).delay(200).slideUp(300);
            });
        });

        // Navigate to the specified route when clicking on dropdown toggle or items for desktop
        $('.nav-item.dropdown .nav-link').on('click', function(event) {
            if ($(window).width() >= 992) {
                event.preventDefault();
                window.location.href = $(this).attr('href');
            }
        });

        // Show/hide dropdown menu on click for mobile
        $('.nav-item.dropdown .nav-link').on('click', function(event) {
            if ($(window).width() < 992) {
                event.preventDefault();
                var dropdownMenu = $(this).siblings('.dropdown-menu');
                dropdownMenu.toggle(); // Toggles the visibility of the dropdown menu
            }
        });

    });
</script>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>