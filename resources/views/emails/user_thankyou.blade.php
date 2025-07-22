<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Thanks {{ $rating->user->name }}!</h2>
    <p>We appreciate your feedback on <strong>{{ $rating->product->name }}</strong>.</p>
    <p>Your rating: <strong>{{ $rating->rating }}/5</strong></p>
    <p>We hope to serve you again soon!</p>

</body>

</html>