$(document).ready(function() {
    $('#table-body').DataTable({
        search: {
            regex: true, // Enable regex search
            smart: false // Disable fuzzy matching
        }
    });

    // Optional: Force exact match search using regex
    $('#table-body_filter input').on('keyup', function() {
        var table = $('#table-body').DataTable();
        table.search('^' + this.value + '$', true, false).draw();
    });
});
