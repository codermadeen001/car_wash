<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Confirmation</title>
    <style>
        :root {
            --primary: #1a3a5f;
            --primary-light: #2c5282;
            --secondary: #ff6b35;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --white: #ffffff;
            --danger: #dc3545;
            --success: #28a745;
            --warning: #ffc107;
            --info: #17a2b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--light-gray) 0%, #e9ecef 100%);
            padding: 20px;
            color: var(--dark-gray);
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }

        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="bubbles" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="2" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23bubbles)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .car-icon {
            font-size: 60px;
            margin-bottom: 20px;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 18px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 40px 30px;
        }

        .confirmation-badge {
            background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
            color: var(--white);
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .details-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: var(--light-gray);
            padding: 25px;
            border-radius: 15px;
            border-left: 5px solid var(--secondary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--secondary), transparent);
            opacity: 0.1;
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 500;
            color: var(--dark-gray);
            position: relative;
            z-index: 1;
        }

        .price-card {
            background: linear-gradient(135deg, var(--secondary) 0%, #ff8c42 100%);
            color: var(--white);
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        .price-label {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .price-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .location-card {
            background: linear-gradient(135deg, var(--info) 0%, #20c997 100%);
            color: var(--white);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .location-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(23, 162, 184, 0.4);
            color: var(--white);
            text-decoration: none;
        }

        .location-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .receipt-section {
            background: var(--white);
            border: 2px dashed var(--primary);
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: center;
        }

        .receipt-title {
            color: var(--primary);
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .receipt-number {
            font-family: 'Courier New', monospace;
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary);
            background: var(--light-gray);
            padding: 15px 20px;
            border-radius: 10px;
            display: inline-block;
            letter-spacing: 2px;
        }

        .footer {
            background: var(--primary);
            color: var(--white);
            padding: 30px;
            text-align: center;
        }

        .footer h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }

        .footer p {
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .divider {
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--primary));
            margin: 30px 0;
            border-radius: 2px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .email-container {
                border-radius: 10px;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .price-value {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="car-icon">🚗</div>
            <h1>Car Wash Complete!</h1>
            <p>Your vehicle is sparkling clean</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="confirmation-badge">
                ✅ Service Confirmed
            </div>

            <!-- Customer Details -->
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-label">
                        👤 Customer Name
                    </div>
                    <div class="detail-value">{{ $username }}</div>
                </div>

                <div class="detail-card">
                    <div class="detail-label">
                        🚗 Vehicle Plate Number
                    </div>
                    <div class="detail-value">{{ $car_plate_number }}</div>
                </div>

                <div class="detail-card">
                    <div class="detail-label">
                        🧽 Service Attendant
                    </div>
                    <div class="detail-value">{{ $washer }}</div>
                </div>

                <div class="detail-card">
                    <div class="detail-label">
                        📅 Service Date & Time
                    </div>
                    <div class="detail-value">{{ $date }}, {{ $day }} at {{ $time }}</div>
                </div>
            </div>

            <!-- Price Section -->
            <div class="price-card">
                <div class="price-label">Total Amount Paid</div>
                <div class="price-value">${{ $price }}</div>
                <div style="font-size: 14px; opacity: 0.9;">Payment Processed Successfully</div>
            </div>

            <!-- Location -->
            <a href="{{ $location_url }}" class="location-card">
                <div class="location-icon">📍</div>
                <div style="font-size: 18px; font-weight: 600;">{{ $location_name }}</div>
                <div style="font-size: 14px; opacity: 0.9; margin-top: 5px;">Click to view on map</div>
            </a>

            <!-- Receipt Section -->
            <div class="receipt-section">
                <div class="receipt-title">📄 Receipt Number</div>
                <div class="receipt-number">{{ $receipt }}</div>
                <p style="margin-top: 15px; color: var(--dark-gray); font-size: 14px;">
                    Keep this receipt for your records
                </p>
            </div>

            <div class="divider"></div>

            <!-- Additional Info -->
            <div style="text-align: center; padding: 20px; background: var(--light-gray); border-radius: 15px; margin-top: 20px;">
                <h3 style="color: var(--primary); margin-bottom: 15px;">Thank You for Choosing Us!</h3>
                <p style="color: var(--dark-gray); margin-bottom: 15px;">
                    We hope you're satisfied with our service. Your car is now clean and ready to hit the road!
                </p>
                <p style="font-size: 14px; color: var(--primary); font-weight: 600;">
                    🌟 Rate your experience • 🔄 Book another wash • 📱 Download our app
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>🚗 Premium Car Wash</h3>
            <p>Quality service, every time</p>
            <p>📧 support@carwash.com | 📞 (555) 123-4567</p>
            <p style="font-size: 12px; margin-top: 15px; opacity: 0.7;">
                This is an automated confirmation email. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>
</html>