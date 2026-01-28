@extends('layouts.app')

@section('title', 'Privacy Policy - ' . config('app.name'))
@section('meta_description', 'Our privacy policy explains how we collect, use, and protect your personal information.')

@section('content')
    <section class="section bg-white">
        <div class="container-main">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900 mb-6">
                    Privacy Policy
                </h1>

                <p class="text-sm text-warm-gray-500 mb-8">Last updated: {{ date('F j, Y') }}</p>

                <div class="prose prose-warm-gray max-w-none">
                    <p class="text-lg text-warm-gray-600 leading-relaxed">
                        Your privacy is important to us. This Privacy Policy explains how {{ config('app.name') }} collects,
                        uses, and safeguards your information when you visit our website.
                    </p>

                    <h2>Information We Collect</h2>

                    <h3>Information You Provide</h3>
                    <p>We may collect information you voluntarily provide, such as:</p>
                    <ul>
                        <li>Name and email address when you contact us</li>
                        <li>Any information you include in messages to us</li>
                    </ul>

                    <h3>Automatically Collected Information</h3>
                    <p>When you visit our site, we may automatically collect:</p>
                    <ul>
                        <li>Browser type and version</li>
                        <li>Operating system</li>
                        <li>Pages visited and time spent</li>
                        <li>Referring website</li>
                        <li>IP address (anonymized)</li>
                    </ul>

                    <h2>How We Use Your Information</h2>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Provide and maintain our website</li>
                        <li>Respond to your inquiries</li>
                        <li>Analyze website usage and improve our content</li>
                        <li>Detect and prevent technical issues</li>
                    </ul>

                    <h2>Cookies and Tracking</h2>
                    <p>
                        We use cookies and similar tracking technologies to enhance your experience. These may include:
                    </p>
                    <ul>
                        <li><strong>Essential cookies:</strong> Required for the website to function</li>
                        <li><strong>Analytics cookies:</strong> Help us understand how visitors use our site</li>
                        <li><strong>Affiliate cookies:</strong> Used by Amazon to track referrals</li>
                    </ul>
                    <p>
                        You can control cookies through your browser settings. However, disabling cookies may affect your
                        experience on our site.
                    </p>

                    <h2>Third-Party Services</h2>
                    <p>We may use third-party services that collect information, including:</p>
                    <ul>
                        <li><strong>Amazon Associates:</strong> When you click affiliate links, Amazon may place cookies to
                            track your purchases</li>
                        <li><strong>Google Analytics:</strong> We may use analytics services to understand website traffic
                        </li>
                    </ul>
                    <p>
                        These third parties have their own privacy policies governing their use of your information.
                    </p>

                    <h2>Data Security</h2>
                    <p>
                        We implement appropriate security measures to protect your information. However, no method of
                        transmission over the Internet is 100% secure, and we cannot guarantee absolute security.
                    </p>

                    <h2>External Links</h2>
                    <p>
                        Our website contains links to external sites, including Amazon. We are not responsible for the
                        privacy practices of these external sites. We encourage you to review their privacy policies.
                    </p>

                    <h2>Children's Privacy</h2>
                    <p>
                        Our website is not intended for children under 13. We do not knowingly collect information from
                        children under 13. If you believe we have collected such information, please contact us.
                    </p>

                    <h2>Changes to This Policy</h2>
                    <p>
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting
                        the new policy on this page and updating the "Last updated" date.
                    </p>

                    <h2>Contact Us</h2>
                    <p>
                        If you have questions about this Privacy Policy, please <a
                            href="{{ route('pages.contact') }}">contact us</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection