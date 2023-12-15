function renderDataTable(url, columns) {
    return $("#simpletable").DataTable({
        ajax: url,
        processing: true,
        serverSide: true,
        columns: columns,
    });
}
