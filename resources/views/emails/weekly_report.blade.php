<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Report</title>
    <style>
        /* 🎨 Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            line-height: 1.6;
            color: #2d3748;
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #eab308 0%, #b45309 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .welcome-badge {
            background-color: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .content {
            padding: 30px;
        }

        .stats-panel {
            background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
            border-left: 5px solid #eab308;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .stats-panel h2 {
            color: #b45309;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .stats-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #eab308;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        .table-wrapper {
            overflow-x: auto;
            margin: 20px 0;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .report-table th {
            background-color: #f3f4f6;
            color: #374151;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #e5e7eb;
        }

        .report-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .report-table tr:hover {
            background-color: #fefce8;
        }

        .btn-container {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #eab308 0%, #b45309 100%);
            color: white;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* 🎨 Empty State Styles */
        .empty-state {
            text-align: center;
            padding: 50px 30px;
            background: linear-gradient(135deg, #fefce8 0%, #fffbeb 100%);
            border-radius: 16px;
            margin: 20px 0;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #b45309;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .btn-small {
            display: inline-block;
            background: linear-gradient(135deg, #eab308 0%, #b45309 100%);
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
        }

        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            color: #9ca3af;
            font-size: 12px;
        }

        .copyright {
            margin-top: 10px;
            font-size: 11px;
            color: #d1d5db;
        }

        @media (max-width: 600px) {
            .content { padding: 20px; }
            .stats-grid { flex-direction: column; }
            .header h1 { font-size: 24px; }
        }
    </style>
</head>
<body style="background-color: #f5f7fa; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f7fa; padding: 20px;">
        <tr>
            <td align="center">
                <div class="email-container">

                    <!-- 🟡 Header -->
                    <div class="header">
                        <div class="welcome-badge">📬 Weekly Digest</div>
                        <h1>📊 Weekly Report</h1>
                        <p>Hello <strong>{{ $adminName }}</strong>! 👋</p>
                    </div>

                    <!-- 📊 Content -->
                    <div class="content">

                        <!-- 📅 Date Range -->
                        <p style="margin-bottom: 25px; color: #4b5563;">
                            Here's your weekly report from
                            <strong style="color: #b45309;">{{ $startDate }}</strong>
                            to
                            <strong style="color: #b45309;">{{ $endDate }}</strong>
                        </p>

                        @if($articles->isNotEmpty())
                            <div class="stats-panel">
                                <h2>📈 Quick Stats</h2>
                                <div class="stats-grid">
                                    <div class="stat-card">
                                        <div class="stat-number">{{ $articles->count() }}</div>
                                        <div class="stat-label">Published Articles</div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-number">{{ $articles->unique('author_id')->count() }}</div>
                                        <div class="stat-label">Active Authors</div>
                                    </div>
                                </div>
                            </div>

                            <h3>📝 Published Articles This Week</h3>
                            <div class="table-wrapper">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($articles as $index => $article)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ \Illuminate\Support\Str::limit($article->title, 40) }}</strong></td>
                                            <td>{{ $article->author?->name ?? 'Unknown' }}</td>
                                            <td>{{ $article->published_at?->format('M d, Y') ?? '—' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="btn-container">
                                <a href="{{ url('/admin/dashboard') }}" class="btn">📋 View Full Dashboard</a>
                            </div>
                        @else
                            {{-- 🎨 ما في مقالات: عرض قالب تشجيعي --}}
                            <div class="empty-state">
                                <div class="empty-state-icon">📭✨</div>
                                <h3>No Articles This Week</h3>
                                <p>It's quiet here... ready for some new stories? 🚀</p>
                                <a href="{{ url('/admin/articles/create') }}" class="btn-small">
                                    ✍️ Write First Article
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- 🔗 Footer -->
                    <div class="footer">
                        <div class="footer-text">
                            This report was generated automatically by <strong>{{ config('app.name') }}</strong> Platform.
                        </div>
                        <div class="copyright">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </div>
                    </div>

                </div>
            </td>
        </tr>
    </table>
</body>
</html>
