import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState } from 'react';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';

const randomNumberInRange = (min:number, max:number) => {
    return Math.floor(Math.random()
        * (max - min + 1)) + min;
};

let cardColor = randomNumberInRange(1,3);
let totalStars = 5;

export default function Dashboard({quote, rating} : {quote:any, rating:number}) {
    const [showRatingModal, setShowRatingModal] = useState(false);

    const closeModal = () => {
        setShowRatingModal(false);
    };

    const [currentRating, setCurrentRating] = useState(rating);
    const [hover, setHover] = useState<number | null>(null);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Your Inspirational Quote
                </h2>
            }
        >
            <Head title="Home" />

            <div className="py-12">
                <div className="blockquote-container">
                    <blockquote className={`q-card q-card-color-${cardColor}`}>
                        <div className="content">{quote.quote}</div>
                        <div className='author'>{quote.author}</div>
                    </blockquote>
                    <div className="text-right">
                        <p>Your rating is: <span className={`star ${currentRating>0 ? 'blue':''}`}>&#9733;</span>{currentRating}</p>
                        <p>
                        <SecondaryButton onClick={() => setShowRatingModal(true)}>
                            Rate
                        </SecondaryButton>
                        </p>
                    </div>
                </div>
            </div>
            <Modal show={showRatingModal} onClose={closeModal}>
                {[...Array(totalStars)].map((star, index) => {
                    return (
                    <label key={index}>
                        <input
                        key={star}
                        type="radio"
                        name="rating"
                        value={(index + 1)}
                        onChange={() => setCurrentRating((index + 1))}
                        />
                        <span
                        className={`star ${((index + 1) <= (hover || currentRating)) ? 'blue':''}`}
                        onMouseEnter={() => setHover(index + 1)}
                        onMouseLeave={() => setHover(null)}
                        >
                        &#9733;
                        </span>
                    </label>
                    );
                })}
            </Modal>
        </AuthenticatedLayout>
    );
}
