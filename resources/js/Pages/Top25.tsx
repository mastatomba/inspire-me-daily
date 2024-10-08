import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import axios from 'axios';
import Modal from '@/Components/Modal';
import RatingBreakdown from '@/Components/RatingBreakdown';
import SecondaryButton from '@/Components/SecondaryButton';

export default function Top25({quotes} : {quotes:Array<any>}) {
    var quoteNumber = 0;

    const [showRatingBreakdownModal, setShowRatingBreakdownModal] = useState(false);

    const closeRatingBreakdownModal = () => {
        setShowRatingBreakdownModal(false);
    };

    const [ratings, setRatings] = useState<object | null>(null);

    const loadRatingsAndShowRatingBreakdownModal = (quote_id:number) => {
        axios.get('/get_rating_breakdown', {
            params: {
              id: quote_id
            }
          })
          .then(function (response) {
            setRatings(response.data);
            setShowRatingBreakdownModal(true);
          })
          .catch(function (error) {
            console.error(error);
          });
    }

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
                                            <span 
                                            className="star yellow"
                                            onClick={() => loadRatingsAndShowRatingBreakdownModal(quote.id)}
                                            >&#9733;</span>{quote.rating} ({quote.votes})
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <Modal show={showRatingBreakdownModal} onClose={closeRatingBreakdownModal}>
                <div className="p-6">
                    <RatingBreakdown ratings={ratings}/>
                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeRatingBreakdownModal}>
                            Close
                        </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </AuthenticatedLayout>
    );
}
