function displayLeadData(lead, cols = false, classs = 'col-md-6', tablecount = 2) {
    // Assuming 'lead' is an object with key-value pairs.
    if (lead) {
        // Remove 'call_history' from the lead object

        // Filter out empty values from the lead object
        lead = Object.fromEntries(Object.entries(lead).filter(([_, v]) => v != null && v !== '' && v !== '0'));

        const container = document.createElement('div');
        container.className = 'container';

        const row = document.createElement('div');
        row.className = 'row';
        container.appendChild(row);

        const col1 = document.createElement('div');
        col1.className = classs;
        row.appendChild(col1);

        const table1 = document.createElement('table');
        table1.className = 'table table-bordered';
        col1.appendChild(table1);

        const col2 = document.createElement('div');
        col2.className = classs;
        row.appendChild(col2);

        const table2 = document.createElement('table');
        table2.className = 'table table-bordered';
        col2.appendChild(table2);

        const half = Math.ceil(Object.keys(lead).length / tablecount) + 1;
        let i = 0;

        Object.entries(lead).forEach(([key, value]) => {
            key = cols ? cols[key] : key;
            if (key != 'call_history') {
                const tr = document.createElement('tr');
                const th = document.createElement('th');
                th.textContent = slugToText(key);
                const td = document.createElement('td');
                let cond = key.toLowerCase();

                // Create clickable links for specific fields
                if (cond.startsWith('address') || cond.endsWith('address')) {
                    const a = document.createElement('a');
                    a.href = 'https://www.google.com/maps/search/' + encodeURIComponent(value);
                    a.textContent = value;
                    a.target = '_blank';
                    td.appendChild(a);
                } else if (cond.startsWith('time') || cond.endsWith('time')) {
                    td.textContent = timestampToHumanTime(parseInt(value) * 1000);
                } else if (cond.startsWith('email') || cond.endsWith('email')) {
                    const a = document.createElement('a');
                    a.href = `tel:${value}`;
                    a.textContent = value;
                    a.target = '_blank';
                    td.appendChild(a);
                } else if (cond.startsWith('phone') || cond.endsWith('phone')) {
                    const a = document.createElement('a');
                    a.href = `tel:${value}`;
                    a.textContent = value;
                    a.target = '_blank';
                    td.appendChild(a);
                } else if (cond === 'website' || cond.endsWith('_url')) {
                    const a = document.createElement('a');
                    a.href = value;
                    a.textContent = value;
                    a.target = '_blank';
                    td.appendChild(a);
                } else {
                    td.textContent = value;
                }

                tr.appendChild(th);
                tr.appendChild(td);

                if (i < half) {
                    table1.appendChild(tr);
                } else {
                    table2.appendChild(tr);
                }
            } else {
                window.call_history = value;
            }
            i++;
        });

        return container;
    } else {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning';
        alertDiv.textContent = 'No lead data available.';
        return alertDiv;
    }
}
function timestampToHumanTime(timestamp) {
    // Create a new Date object from the timestamp
    const date = new Date(timestamp);

    // Options for formatting the date and time
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    };

    // Format the date and time using the options
    return date.toLocaleString('en-US', options);
}


function slugToText(slug) {
    // Replace hyphens with spaces and split the string into words
    let words = slug.replace(/-/g, ' ').replace(/_/g, ' ').split(' ');

    // Capitalize the first letter of each word
    let capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));

    let readableText = capitalizedWords.join(' ');
    return readableText;
}