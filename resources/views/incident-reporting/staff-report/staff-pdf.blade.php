<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
        }

        .header img {
            height: 50px;
            width: auto;
            display: inline-block;
        }

        .title {
            font-weight: bold;
            text-align: center;
            margin-top: 1rem;
        }

        .fields {
            margin-top: 1rem;
        }

        .fields p {
            margin: 0.2rem 0;
        }

        .body-text {
            margin-top: 1rem;
            text-align: justify;
        }

        /* Space between description HR and images */
        .image-wrapper {
            margin-top: 1.5rem;
        }

        /* Image section grid */
        .image-section {
            display: grid;
            gap: 0.8rem;
            justify-items: center;
            align-items: center;
            width: 100%;
        }

        /* Standard image size (always centered) */
        .image-section img {
            width: 220px;
            /* fixed width */
            height: 160px;
            /* fixed height */
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border: 1px solid #ccc;
            /* optional, helps see boundaries */
            padding: 2px;
        }

        /* Layouts based on image count */
        .image-section.one {
            grid-template-columns: 1fr;
        }

        .image-section.two {
            grid-template-columns: repeat(2, 1fr);
        }

        .image-section.three {
            grid-template-columns: repeat(3, 1fr);
        }

        .image-section.four {
            grid-template-columns: repeat(2, 1fr);
        }

        .image-section.five {
            grid-template-columns: repeat(3, 1fr);
        }

        .image-section.five img:nth-child(4),
        .image-section.five img:nth-child(5) {
            grid-column: span 1;
        }

        .signature {
            margin-top: 3rem;
            padding-left: 3rem;
            /* indent whole block */
            text-align: left;
            width: fit-content;
            /* shrink to contents */
        }

        .signature-line {
            width: 220px;
            /* longer line */
            border-top: 1px solid #000;
            margin: 0.2rem 0;
            position: relative;
        }

        .signature .name,
        .signature .label {
            margin: 0.2rem 0;
            width: 220px;
            /* same as line width */
            text-align: center;
            /* centers text on line */
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/SMI_logo.png') }}" alt="Large Logo">
        <p>Republic of the Philippines
            <br> Municipal Disaster Risk Reduction and Management Office-San Mateo
            <br>VHJP+FJ2, San Mateo, Isabela
            <br>land lines: Globe: 0926-280-3804 SMART: 0961-541-7453
            <br>ndrrmoc@ocd.gov.ph
        </p>
    </div>

    <div class="title">Incident and Crime report</div>

    <div class="fields">
        <p><strong>SENDER:</strong> {{ $report->user_name }}</p>
        <p><strong>SUBJECT:</strong> {{ $report->report_title }}</p>
        <p><strong>DATE:</strong> {{ $report->report_date }}</p>
        <p>
            <strong>STATUS:</strong>
            @php
                $status = strtolower($report->report_status);
                $badgeColor = match ($status) {
                    'approved' => '#16a34a', // green
                    'rejected' => '#dc2626', // red
                    'pending' => '#ca8a04', // yellow
                    default => '#6b7280', // gray
                };
            @endphp
            <span
                style="
        display:inline-block;
        padding:1px 5px;
        border-radius:100%;
        background-color: {{ $badgeColor }};
        color:#fff;
        font-size:12px;
        font-weight:600;
    ">
                {{ ucfirst($report->report_status) }}
            </span>
        </p>

    </div>
    <hr>

    <div class="body-text">
        {!! nl2br(e($report->report_description)) !!}
    </div>

    <hr>

    <br>

    @if ($report->images->count())
        <div class="image-wrapper">
            <div
                class="image-section
                @if ($report->images->count() === 1) one
                @elseif($report->images->count() === 2) two
                @elseif($report->images->count() === 3) three
                @elseif($report->images->count() === 4) four
                @elseif($report->images->count() === 5) five @endif
            ">
                @foreach ($report->images as $image)
                    <img src="{{ public_path('storage/' . $image->file_path) }}">
                @endforeach
            </div>
        </div>
    @endif

    <div class="signature">
        <p class="name">MDRRMO</p>
        <div class="signature-line"></div>
        <p class="label"><strong>Signature</strong></p>
    </div>

</body>

</html>
