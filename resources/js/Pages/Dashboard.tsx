import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({quote, card_color} : {quote:any, card_color:number}) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <blockquote className={`q-card q-card-color-${card_color}`}>
                                <div className="content">{quote.quote}</div>
                                <div className='author'>{quote.author}</div>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
