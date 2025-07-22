<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>New Rating Received</h2>
    <p><strong>Product:</strong> {{ $rating->product->name }}</p>
    <p><strong>By:</strong> {{ $rating->user->name }} ({{ $rating->user->email }})</p>
    <p><strong>Rating:</strong> {{ $rating->rating }}/5</p>
    <p><strong>Comment:</strong> {{ $rating->comment ?? 'No comment' }}</p>
</body>

</html>