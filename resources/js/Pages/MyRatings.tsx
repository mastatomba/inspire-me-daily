import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import axios from 'axios';
import Modal from '@/Components/Modal';
import RatingBreakdown from '@/Components/RatingBreakdown';
import SecondaryButton from '@/Components/SecondaryButton';

export default function MyRatings({quotes} : {quotes:Array<any>}) {
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
                    My ratings
                </h2>
            }
        >
            <Head title="My ratings" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {quotes.length>0 ? (
                                <table className="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                    <thead className="border-b border-neutral-200 bg-neutral-50 font-medium dark:border-white/10 dark:text-neutral-800">
                                        <tr>
                                        <th scope="col" className="px-6 py-4">#</th>
                                        <th scope="col" className="px-6 py-4">Author</th>
                                        <th scope="col" className="px-6 py-4">Quote</th>
                                        <th scope="col" className="px-6 py-4">My rating</th>
                                        <th scope="col" className="px-6 py-4">InspireMeDaily rating</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {quotes.map((quote) => (
                                        <tr id={`${quote.id}`} className="border-b border-neutral-200 transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-white/10 dark:hover:bg-neutral-600">
                                            <td className="whitespace-nowrap px-6 py-4 font-medium">{++quoteNumber}</td>
                                            <td className="whitespace-nowrap px-6 py-4">{quote.author}</td>
                                            <td className="px-6 py-4">{quote.quote}</td>
                                            <td className="whitespace-nowrap px-6 py-4">
                                                <span className="star blue">&#9733;</span>{quote.my_rating}
                                            </td>
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
                            ) : (
                                <p>You have not rated any quotes yet. Open <a href={route('dashboard')}>home</a> to get a new inspirational quote!</p>
                            )}
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
