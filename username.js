function get_username() {
    const pairs = document.cookie.split('; ');
    for (const pair of pairs) {
        if (pair.startsWith('username=')) {
            return pair.substring(9);
        }
    }
    return '';
}
