import InputError from "@/Components/InputError";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import { Input, Checkbox, Button, Typography } from "@material-tailwind/react";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: "",
        last_name: "",
        public_name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("register"), {
            onFinish: () =>
                reset(
                    "first_name",
                    "last_name",
                    "public_name",
                    "email",
                    "password",
                    "password_confirmation"
                ),
        });
    };

    return (
        <>
            <Head title="Register" />

            <section className="m-8 flex">
                <div className="w-2/5 h-full hidden lg:block">
                    <img
                        src="/images/pattern.png"
                        className="h-full w-full object-cover rounded-3xl"
                    />
                </div>
                <div className="w-full lg:w-3/5 flex flex-col items-center justify-center">
                    <div className="text-center">
                        <Typography variant="h2" className="font-bold mb-4">
                            Join Us Today
                        </Typography>
                        <Typography
                            variant="paragraph"
                            color="blue-gray"
                            className="text-lg font-normal"
                        >
                            Enter your email and password to register.
                        </Typography>
                    </div>
                    <form
                        className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2"
                        onSubmit={submit}
                    >
                        <div className="mb-1 flex flex-col gap-6">
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Name
                            </Typography>
                            <div className="flex gap-2">
                                <TextInput
                                    id="first_name"
                                    type="text"
                                    name="first_name"
                                    value={data.first_name}
                                    className="mt-1 block w-1/2"
                                    autoComplete="first_name"
                                    placeholder="First Name"
                                    onChange={(e) =>
                                        setData("first_name", e.target.value)
                                    }
                                    required
                                />
                                <TextInput
                                    id="last_name"
                                    type="text"
                                    name="last_name"
                                    value={data.last_name}
                                    className="mt-1 block w-1/2"
                                    autoComplete="last_name"
                                    placeholder="Last Name"
                                    onChange={(e) =>
                                        setData("last_name", e.target.value)
                                    }
                                    required
                                />
                            </div>
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Public Name
                            </Typography>
                            <TextInput
                                id="public_name"
                                type="text"
                                name="public_name"
                                value={data.public_name}
                                className="mt-1 block w-full"
                                autoComplete="public_name"
                                placeholder="Public Name"
                                onChange={(e) =>
                                    setData("public_name", e.target.value)
                                }
                                required
                            />
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Your email
                            </Typography>
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                autoComplete="username"
                                placeholder="name@mail.com"
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                                required
                            />
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Password
                            </Typography>
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full"
                                autoComplete="new-password"
                                placeholder="Password"
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                                required
                            />
                            <Typography
                                variant="small"
                                color="blue-gray"
                                className="-mb-3 font-medium"
                            >
                                Confirm Password
                            </Typography>
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                className="mt-1 block w-full"
                                autoComplete="new-password"
                                placeholder="Confirm Password"
                                onChange={(e) =>
                                    setData(
                                        "password_confirmation",
                                        e.target.value
                                    )
                                }
                                required
                            />
                        </div>
                        <Checkbox
                            label={
                                <Typography
                                    variant="small"
                                    color="gray"
                                    className="flex items-center justify-start font-medium"
                                >
                                    I agree the&nbsp;
                                    <a
                                        href="#"
                                        className="font-normal text-black transition-colors hover:text-gray-900 underline"
                                    >
                                        Terms and Conditions
                                    </a>
                                </Typography>
                            }
                            containerProps={{ className: "-ml-2.5" }}
                        />
                        <Button className="mt-6" fullWidth type="submit">
                            Register Now
                        </Button>
                        <Typography
                            variant="paragraph"
                            className="text-center text-blue-gray-500 font-medium mt-4"
                        >
                            Already have an account?
                            <Link href="/login" className="text-gray-900 ml-1">
                                Sign in
                            </Link>
                        </Typography>
                    </form>
                </div>
            </section>
        </>
    );
}
