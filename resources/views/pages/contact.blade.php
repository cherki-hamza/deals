@extends('layouts.app')

@section('title', 'Contact Us - ' . config('app.name'))
@section('meta_description', 'Get in touch with us. We would love to hear your feedback, questions, or suggestions.')

@section('content')
    <section class="section bg-white">
        <div class="container-main">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-3xl lg:text-4xl font-bold font-heading text-warm-gray-900 mb-4 text-center">
                    Contact Us
                </h1>
                <p class="text-lg text-warm-gray-600 text-center mb-12">
                    Have a question or feedback? We'd love to hear from you!
                </p>

                <div class="card p-8">
                    <form action="#" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-warm-gray-700 mb-2">
                                Your Name
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 rounded-xl border border-warm-gray-200 focus:border-amber-accent-500 focus:ring-2 focus:ring-amber-accent-200 transition-colors"
                                placeholder="John Doe">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-warm-gray-700 mb-2">
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 rounded-xl border border-warm-gray-200 focus:border-amber-accent-500 focus:ring-2 focus:ring-amber-accent-200 transition-colors"
                                placeholder="john@example.com">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-warm-gray-700 mb-2">
                                Subject
                            </label>
                            <select id="subject" name="subject"
                                class="w-full px-4 py-3 rounded-xl border border-warm-gray-200 focus:border-amber-accent-500 focus:ring-2 focus:ring-amber-accent-200 transition-colors">
                                <option value="general">General Inquiry</option>
                                <option value="feedback">Feedback</option>
                                <option value="suggestion">Product Suggestion</option>
                                <option value="issue">Report an Issue</option>
                                <option value="partnership">Partnership / Business</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-warm-gray-700 mb-2">
                                Message
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 rounded-xl border border-warm-gray-200 focus:border-amber-accent-500 focus:ring-2 focus:ring-amber-accent-200 transition-colors resize-none"
                                placeholder="How can we help you?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-amazon w-full">
                            Send Message
                        </button>
                    </form>
                </div>

                <div class="mt-12 text-center text-warm-gray-500">
                    <p>
                        Prefer email? Reach us at
                        <a href="mailto:hello@example.com"
                            class="text-amber-accent-600 hover:text-amber-accent-700 font-medium">
                            hello@example.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection