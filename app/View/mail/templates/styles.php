<style>
    body {
        background-color: #DDD;
        padding: 2em;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    p,
    span,
    h1, h2, h3, h4, h5, h6,
    i,
    a,
    input,
    textarea,
    select,
    label,
    li {
        font-family: sans-serif;
    }

    .card {
        background-color: white;
        border-radius: 30px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        max-width: 700px;
    }

    .header-container {
        background-color: #222;
        display: flex;
        flex-direction: column;
        color: #FFF;
        align-items: center;
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
        object-fit: cover;
    }
    .header-container img {
        filter: invert(1);
        margin: 10px;
        height: 70px;
    }
    .header-container h1 {
        margin-top: 0;
        text-align: center;
    }

    .text-container {
        color: #333;
        padding: 3em 3em 1em;
    }
    .text-container h2,
    .text-container p {
        color: inherit;
        margin: 0;
    }

    .under-button-container,
    .button-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .button-container a {
        background-color: #0074FF;
        color: white;
        border-radius: 5px;
        padding: 1em;
        margin: 1em;
        text-decoration: none;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    }

    .under-button-container p {
        font-size: 0.8em;
        color: #555;
        padding: 1em 3em;
    }
    .under-button-container a {
        white-space: pre;
    }

    .footer {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .footer * {
        color: #555;
        text-align: center;
        font-size: 0.7em;
        margin: 0.5em 0 0;
    }
</style>