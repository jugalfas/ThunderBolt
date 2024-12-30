import PropTypes from "prop-types";
import { Card, Avatar, Typography } from "@material-tailwind/react";
import { Link } from "@inertiajs/react";

export function PostCard({
    img,
    name,
    excerpt, // Default value directly in the parameter
    socials = null, // Default value directly in the parameter
}) {
    return (
        <Card color="transparent" shadow={false} className="text-center">
            <Avatar
                src={img}
                alt={name}
                size="xxl"
                variant="rounded"
                className="flex-shrink-0 rounded-lg w-full h-56 object-cover object-center"
            />
            <Typography variant="h5" color="blue-gray" className="mt-6 mb-1">
                {name}
            </Typography>
            {excerpt && (
                <Typography
                    className="font-normal text-blue-gray-500 mt-6 mb-1"
                >
                    {excerpt}
                </Typography>
            )}
            <Link href="#" className="mt-6 ml-auto mr-auto w-1/2 p-1 btn hover:bg-gray-900 hover:text-white bg-white text-gray-900 border border-gray-900 rounded">Read More</Link>
        </Card>
    );
}

PostCard.propTypes = {
    img: PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    excerpt: PropTypes.string,
    socials: PropTypes.node,
};

PostCard.displayName = "/src/widgets/layout/team-card.jsx";

export default PostCard;
