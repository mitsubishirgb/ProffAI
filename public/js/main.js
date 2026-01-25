function load_component(component_path) {
    const component_name = component_path.split("/").pop().replace(".html", "");

    fetch(component_path)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        document.getElementById(component_name + '-placeholder').innerHTML = data;
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });
}
