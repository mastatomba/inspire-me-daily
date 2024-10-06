import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import React, { useState } from "react";

export default function Dashboard({quotes} : {quotes:Array<any>}) {
    var quoteNumber = 0;

    // const [isChecked, setIsChecked] = useState(false)

    // const handleCheckboxChange = () => {
    // setIsChecked(!isChecked)
    // }

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Top 25 quotes
                </h2>
            }
        >
            <Head title="Top 25 quotes" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {/* <div>
                                <label className='flex cursor-pointer select-none items-center'>
                                    <div className='relative'>
                                    <input
                                        type='checkbox'
                                        checked={isChecked}
                                        onChange={handleCheckboxChange}
                                        className='sr-only'
                                    />
                                    <div className='block h-8 w-14 rounded-full border border-[#BFCEFF] bg-[#EAEEFB]'></div>
                                    <div className='dot bg-primary absolute left-1 top-1 h-6 w-6 rounded-full transition'></div>
                                    </div>
                                </label> Show my ratings
                            </div> */}
                            <table className="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                <thead className="border-b border-neutral-200 bg-neutral-50 font-medium dark:border-white/10 dark:text-neutral-800">
                                    <tr>
                                    <th scope="col" className="px-6 py-4">#</th>
                                    <th scope="col" className="px-6 py-4">Author</th>
                                    <th scope="col" className="px-6 py-4">Quote</th>
                                    <th scope="col" className="px-6 py-4">Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {quotes.map((quote) => (
                                    <tr id={`${quote.id}`} className="border-b border-neutral-200 transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-white/10 dark:hover:bg-neutral-600">
                                        <td className="whitespace-nowrap px-6 py-4 font-medium">{++quoteNumber}</td>
                                        <td className="whitespace-nowrap px-6 py-4">{quote.author}</td>
                                        <td className="px-6 py-4">{quote.quote}</td>
                                        <td className="whitespace-nowrap px-6 py-4">
                                            <span className="star" style={{ color:'#ffc107' }}>★</span>{quote.rating} ({quote.votes})
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}