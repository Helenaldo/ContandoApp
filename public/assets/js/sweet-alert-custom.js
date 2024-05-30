function showSwal(type, icon, title) {
    if (type === 'custom-position') {
        Swal.fire({
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 2000
        });
    }
}
