<?php
include "shared/header.php"
?>
    <title>User - Platypurse</title>
</head>
<body>

<?php
include "shared/nav.php"
?>
<h2>{{USER_NAME}} Page</h2>
{{DISPLAY_NAME}}
<br>
{{DISPLAY_AVATAR}}
<br>

    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non metus 
    fermentum, ornare orci ac, bibendum sapien. Sed lacinia erat ac auctor
    ornare. Maecenas a aliquam lacus, at iaculis nunc. Proin viverra magna ipsum, non
    viverra odio consectetur eget. Phasellus tempus ornare vulputate. Lorem ipsum dolor
    sit amet, consectetur adipiscing elit. Suspendisse quis magna sed nisl porttitor 
    commodo at non neque. Ut dapibus turpis sed nibh placerat, id pharetra nibh fermentum. 
    Nullam ac lacinia odio. Phasellus ullamcorper erat a convallis scelerisque.<br>
{{DISPLAY_LOCATION}}<br>
    In efficitur cursus tempor. Aenean sed volutpat metus. Nullam rutrum maximus tempor. 
    Vivamus venenatis tempor mauris, id sagittis augue gravida ut. Etiam leo nisi, iaculis pretium tellus eget, elementum viverra nulla. 
    Nam sed dui nulla. 
    Fusce tempor ante eget tortor ullamcorper varius. Aliquam erat volutpat. Praesent lacus leo, 
    laoreet non consectetur sed, lobortis a quam. 
    {{DISPLAY_OFFERS}}

    <?php
        include "shared/footer.php"
    ?>

</body>
</html>