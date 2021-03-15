<script>
var KTTagifyDemos = function() {
    var categories = function() {
        var input = document.getElementById('categories_tagify');
        var tagify = new Tagify(input, {
                whitelist: [<?php foreach($categories as $kC => $c) { echo ($kC != 0) ? ',"'.$c['name'].'"' : '"'.$c['name'].'"'; } ?>],
            })
    }

    var tags = function() {
        var input = document.getElementById('tags_tagify');
        var tagify = new Tagify(input, {
            enforceWhitelist: true,
            whitelist: [<?php foreach($tags as $kT => $t) { echo ($kT != 0) ? ',"'.$t['name'].'"' : '"'.$t['name'].'"'; } ?>],
            // callbacks: {
            //     add: console.log, // callback when adding a tag
            //     remove: console.log // callback when removing a tag
            // }
        });
    }

    return {
        // public functions
        init: function() {
            categories();
            tags();
        }
    };
}();

jQuery(document).ready(function() {
    KTTagifyDemos.init();
});

</script>